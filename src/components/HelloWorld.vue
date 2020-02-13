<template>
  <div class="hello">
    <h1>{{ msg }}</h1>
    <myupload
      class="upload"
      :limit="1"
      :action="'http://museum.com/upload/upload.php'"
      :folder="'upload2/'"
      :ext="ext"
      @getData="getData"
    />
  </div>
</template>

<script>
import myupload from "./upload";
export default {
  name: "HelloWorld",
  data() {
    return {
      ext: [".md", ".txt"]
    };
  },
  props: {
    msg: String
  },
  components: {
    myupload
  },
  methods: {
    getData(newVal, oldVal) {
      console.log(newVal);
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.upload {
  width: 800px;
  margin: 0px auto;
  text-align: center;
}
</style>
