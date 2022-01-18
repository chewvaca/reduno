<template>
  <div class="col-4 justify-content-center mx-auto my-auto">
    <label :for="title">{{text}}</label>
    <input :type="type" :name="title" />
  </div>
</template>
<script>
export default {

    props:{
        type:String,
        title:String,
        text:String,
    },

}
</script>
