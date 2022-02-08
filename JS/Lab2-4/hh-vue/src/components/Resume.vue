<template>
  <div>
    <b-container class="my-5">
      <b-row>
        <b-col class="resume-form">
          <ResumeForm
              @resume-show="showResume"
          />
        </b-col>
        <b-col>
          <ResumeShow 
            :resume="resume"/>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
  import ResumeShow from './ResumeShow.vue'
  import ResumeForm from './ResumeForm.vue'
  export default {
    name: 'Resume',
    components: {
      ResumeShow,
      ResumeForm
    },
    data() {
      return {
          resume: Object,
        }
    },
    methods: {
      showResume(value) {
        this.resume = value;
      }
    }
  }
</script>