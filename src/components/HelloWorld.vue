<template>
  <div class="hello">
    <h1>{{ msg }}</h1>
    <input type="text" :value="img" placeholder="图片" />
    <myupload class="upload" :id="'img'" :limit="1" :type="'image'" :action="'http://museum.com/upload/upload.php'"
      :folder="'upload/'" :autoName="1" :size="1024" @getList="getList" @getProgress="getProgress">
    </myupload>
    <input type="text" :value="file" placeholder="文件" />
    <myupload class="upload" :id="'file'" :limit="1" :type="'file'" :ext="ext"
      :action="'http://museum.com/upload/upload.php'" :folder="'upload2/'" :autoName="1" :size="1024"
      @getList="getList2" @getProgress="getProgress">
    </myupload>
  </div>
</template>

<script>
  import myupload from "./upload";
  export default {
    name: "HelloWorld",
    data() {
      return {
        data: [],
        ext: [".md", ".txt", ".zip"],
        file: "",
        img: "",
      };
    },
    props: {
      msg: String
    },
    components: {
      myupload
    },
    methods: {
      getList(newVal, oldVal) {
        if (newVal.length > 0)
          this.img = newVal[0].url;
      },
      getList2(newVal, oldVal) {
        if (newVal.length > 0)
          this.file = newVal[0].url;
      },
      getProgress(pro) {
        console.log("过程");
      }
    }
  };
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .hello {
    width: 800px;
    margin: 0px auto;
    text-align: center;
  }

  input {
    width: 100%;
    margin: 10px 0px;
    padding: 8px;
  }
</style>