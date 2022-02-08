<template>
  <div id="app">
    <Navbar/>
    <Resume/>
  </div>
</template>

<script>
import Navbar from './components/Navbar.vue'
import Resume from './components/Resume.vue'


export default {
  name: 'App',
  components: {
    Navbar,
    Resume,
  }
}
</script>
