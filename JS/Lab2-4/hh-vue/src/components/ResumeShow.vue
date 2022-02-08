<template>
    <div>
        <b-card border-variant="danger">
            <b-row>
                <b-col cols="4" class="m-2">
                    <b-avatar rounded="lg" size="200px" :src="avatar"></b-avatar>
                </b-col>
                <b-col>
                    <h2>Основная информация</h2>
                    <b-row class="mb-3">ФИО: {{ resume.fio }}</b-row>
                    <b-row class="mb-3">Город: {{ resume.city }}</b-row>
                    <b-row>Дата рождения: {{ resume.birthday }}</b-row>
                </b-col>
            </b-row>
            <b-card header="Контакты" class="mb-2">
                <b-row class="mb-3">Телефон: {{ resume.phone }}</b-row>
                <b-row>Email: {{ resume.email }}</b-row>
            </b-card>
            <b-card header="Образование" class="mb-2">
                <b-row class="mb-3">Уровень образования: {{ resume.education.level }}</b-row>
                <template v-if="educationLevelCheck">
                    <b-row class="mb-3">Университет: {{ resume.education.university }}</b-row>
                    <b-row class="mb-3">Факультет: {{ resume.education.faculty }}</b-row>
                    <b-row class="mb-3">Специализация: {{ resume.education.specialization }}</b-row>
                    <b-row class="mb-3">Год окончания: {{ resume.education.gradYear }}</b-row>

                </template>
                <b-row>Профессия: {{ resume.profession }}</b-row>
            </b-card>
            <b-card header="Работа">
                <b-row class="mb-3">Желаемая зарплата: {{ resume.salary }}</b-row>
                <b-row class="mb-3">Ключевые навыки: {{ resume.skills }}</b-row>
                <b-row>О себе: {{ resume.description }}</b-row>
            </b-card>
        </b-card>
    </div>
</template>

<script>
    export default {
        name: 'ResumeShow',
        props: {
            resume: Object
        },
        data() {
            return {
                imageError: false,
                defaultAvatar: require('@/assets/avatar.png')
            }
        },
        computed: {
            avatar() {
                return this.imageError ? this.defaultAvatar : this.resume.photo
            },
            educationLevelCheck() {
              return ['Среднее специальное', 'Неоконченное высшее', 'Высшее'].includes(this.resume.education.level);
            },
        }
    }
</script>

<style scoped>
    .resume-photo {
        width: 250px;
        height: auto;
    }
</style>