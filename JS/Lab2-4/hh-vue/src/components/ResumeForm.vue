<template>
 
   
          <b-card border-variant="danger">
             
            <b-form>
              <b-card header="Основная информация" class="mb-2">
               
               <BInput 
                  id="fio-input"
                  label="ФИО"
                  placeholder="Введите свое ФИО"
                  v-model="resume.fio"                 
                />

                <BInput 
                  id="city-input"
                  label="Город"
                  placeholder="Введите город проживания"
                  v-model="resume.city"                 
                />

                <BInput 
                  id="birthday-input"
                  label="Дата рождения"
                  placeholder="Дата рождения"
                  type="date"
                  v-model="resume.birthday"             
                />

                <BInput 
                  id="photo-input"
                  label="Ссылка на фото"
                  placeholder="Введите ссылку на фото"
                  v-model="resume.photo"                 
                />

              </b-card>

              <b-card header="Контакты" class="mb-2">
                <BInput
                  id="phone-input"
                  label="Телефон"
                  placeholder="Введите свой номер телефона"
                  v-model="resume.phone"
                  :rules="phoneRules"
                  @validation="updateButtonState"
                />
              
                <BInput 
                  id="email-input"
                  label="Email"
                  placeholder="Введите email"
                  v-model="resume.email"                 
                />
              </b-card>
              
              <b-card header="Образование" class="mb-2">
               
                   <BSelect
                    id="education-level-select"
                    label="Уровень образования"
                    v-model="resume.education.level"
                    :options="educationLevelOptions"
                   />

                   <template v-if="educationLevelCheck">
                    <BInput 
                     id="university-input"
                     label="Учебное заведение"
                     placeholder="Учебное заведение"
                     v-model="resume.education.university"                 
                     />

                     <BInput 
                     id="faculty-input"
                     label="Факультет"
                     placeholder="Факультет"
                     v-model="resume.education.faculty"                 
                     />

                     <BInput 
                     id="specialization-input"
                     label="Специализация"
                     placeholder="Специализация"
                     v-model="resume.education.specialization"                 
                     />

                     <BInput 
                     id="grad-year-input"
                     label="Год окончания"
                     placeholder="Год окончания"
                     v-model="resume.education.gradYear"
                     />
                   </template>
                <BInput 
                  id="profession-input"
                  label="Профессия"
                  placeholder="Введите свою профессию"
                  v-model="resume.profession"                 
                />

              </b-card>
              <b-card header="Работа">
                <BInput 
                  id="salary-input"
                  label="Желаемая зарплата"
                  placeholder="Желаемая зарплата"
                  v-model="resume.salary"                 
                />

                <BInput 
                  id="skills-input"
                  label="Ключевые навыки"
                  placeholder="Ключевые навыки"
                  v-model="resume.skills"                 
                />

                <b-form-group id='description' label="O себе:" label-for="description-input">
                  <b-form-textarea id="description-input" v-model="resume.description" placeholder="О себе..." rows="3"
                    max-rows="6"></b-form-textarea>
                </b-form-group>

              </b-card>
            </b-form>
            <b-button
                variant="danger"
                :disabled="buttonState"
                @click="showResume"
            >
              Сохранить
            </b-button>
          </b-card>

       
</template>

<script>
  import BInput from './BInput.vue'
  import BSelect from './BSelect.vue'
  export default {
    name: 'ResumeForm',
    components: {
      BInput,
      BSelect
    },
    data() {
      return {
        resume: {
          profession: '',
          city: '',
          photo: undefined,
          fio: '',
          phone: '',
          email: '',
          birthday: '',
          education: {
            level: null,
            university: '',
            faculty: '',
            specialization: '',
            gradYear: '',
          },
          salary: '',
          skills: '',
          description: ''
        },

        phoneRules: [
            {regex: /^\d*$/i, message: 'Телефон должен состоять только из цифр'},
            {regex: /^.{6,10}$/i, message: 'Телефон должен содержать от 6 до 10 символов'}
        ],
        educationLevelOptions: [
          { value: null, text: 'Выберете уровень образования' },
          { value: 'Среднее', text: 'Среднее' },
          { value: 'Среднее специальное', text: 'Среднее специальное' },
          { value: 'Неоконченное высшее', text: 'Неоконченное высшее' },
          { value: 'Высшее', text: 'Высшее' },
        ],
        buttonState: false
      }
    },
    computed: {
      educationLevelCheck() {
        return ['Среднее специальное', 'Неоконченное высшее', 'Высшее'].includes(this.resume.education.level);
      },

      avatar() {
        return this.imageError ? this.defaultAvatar : this.resume.photo;
      },
    },

    methods: {
      updateButtonState(state) {
        this.buttonState = state;
      },

      showResume() {
        this.$emit('resume-show', this.resume);
      }
    }
  }
</script>