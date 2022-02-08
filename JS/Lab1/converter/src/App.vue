<template>
  <div id="app">
    <Converter msg="Welcome to Your Vue.js App"/>
  </div>
</template>

<script>
import Converter from './components/Converter.vue'

export default {
  name: 'App',
  components: {
    Converter
  }
}
</script>