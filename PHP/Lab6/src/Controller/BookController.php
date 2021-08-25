<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/book")
 */
class BookController extends AbstractController
{
    /**
     * @Route("/", name="book_index", methods={"GET"})
     */
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findBy([], ['readDate' => 'DESC']),
        ]);
    }

    /**
     * @Route("/user", name="user_list", methods={"GET"})
     */
    public function userBooksList(BookRepository $bookRepository): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('book_index');
        }

        return $this->render('book/user_list.html.twig', [
            'books' => $bookRepository->findBy(['owner' => $this->getUser()], ['readDate' => 'DESC'])]);
    }

    /**
     * @Route("/new", name="book_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('book_index');
        }

        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coverFile = $form->get('cover')->getData();
            $pdfFile = $form->get('pdf')->getData();

            if ($coverFile) {
                $coversTargetDirectory = $this->getParameter('covers_directory');
                $coverFileUploader = new FileUploader($coversTargetDirectory, $slugger);
                $coverNewFilename = $coverFileUploader->upload($coverFile);

                $book->setCover($coverNewFilename);
            }

            if ($pdfFile) {
                $pdfsTargetDirectory = $this->getParameter('pdfs_directory');
                $pdfFileUploader = new FileUploader($pdfsTargetDirectory, $slugger);
                $pdfNewFilename = $pdfFileUploader->upload($pdfFile);

                $book->setPdf($pdfNewFilename);
            }

            $book->setOwner($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book/new.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="book_show", methods={"GET"})
     */
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="book_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Book $book, SluggerInterface $slugger): Response
    {
        if (!$this->getUser() || !($book->getOwner() == $this->getUser()) ){
            return $this->redirectToRoute('book_index');
        }

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coverFile = $form->get('cover')->getData();
            $coversTargetDirectory = $this->getParameter('covers_directory');
            $coverFileUploader = new FileUploader($coversTargetDirectory, $slugger);

            $pdfFile = $form->get('pdf')->getData();
            $pdfsTargetDirectory = $this->getParameter('pdfs_directory');
            $pdfFileUploader = new FileUploader($pdfsTargetDirectory, $slugger);

            if ($book->getCover()) {
                $coverFileUploader->remove($book->getCover());
                $book->setCover(null);
            }

            if ($book->getPdf()) {
                $pdfFileUploader->remove($book->getPdf());
                $book->setPdf(null);
            }

            if ($coverFile) {
                $coverNewFilename = $coverFileUploader->upload($coverFile);
                $book->setCover($coverNewFilename);
            }

            if ($pdfFile) {
                $pdfNewFilename = $pdfFileUploader->upload($pdfFile);
                $book->setPdf($pdfNewFilename);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book/edit.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="book_delete", methods={"POST"})
     */
    public function delete(Request $request, Book $book, SluggerInterface $slugger): Response
    {
        if (!$this->getUser() || !($book->getOwner() == $this->getUser()) ){
            return $this->redirectToRoute('book_index');
        }

        if ($this->isCsrfTokenValid('delete' . $book->getId(), $request->request->get('_token'))) {
            $coversTargetDirectory = $this->getParameter('covers_directory');
            $coverFileUploader = new FileUploader($coversTargetDirectory, $slugger);

            $pdfsTargetDirectory = $this->getParameter('pdfs_directory');
            $pdfFileUploader = new FileUploader($pdfsTargetDirectory, $slugger);

            $coverFileUploader->remove($book->getCover());
            $pdfFileUploader->remove($book->getPdf());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($book);
            $entityManager->flush();
        }

        return $this->redirectToRoute('book_index', [], Response::HTTP_SEE_OTHER);
    }
}
