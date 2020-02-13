<template>
  <div class="myUpload">
    <div class="myUpload-img" v-for="(item,index) in data" :key="index">
      <img :src="item.src" v-if="item.src" />
      <div class="fileLogo" v-if="!item.src">{{item.ext}}</div>
      <div class="delete" @click="del(item)">
        <span>删除</span>
      </div>
    </div>
    <label for="file" class="btn" v-if="limit?data.length < limit:true">
      <div>+</div>
      <input
        type="file"
        id="file"
        class="inputfile"
        @change="handlerUpload($event)"
        :accept="accept"
      />
    </label>
  </div>
</template>

<script>
import axios from "axios";
export default {
  components: {},
  props: ["limit", "action", "folder", "ext"],
  data() {
    return {
      data: [],
      progress: ""
    };
  },
  computed: {
    accept() {
      return this.ext ? this.ext.join() : ".";
    }
  },
  watch: {
    data: {
      handler(newVal, oldVal) {
        this.$emit("getData", newVal, oldVal);
      },
      immediate: true
    }
  },
  methods: {
    isImg(file, obj) {
      if (!file.type.indexOf("image/") == -1) {
        let fileReader = new FileReader();
        fileReader.readAsDataURL(file);
        fileReader.onload = function(ev) {
          obj.src = ev.target.result;
          this.data.push(obj);
        };
      }else{
          this.data.push(obj);
      }
    },
    del(item) {
      this.data = this.data.filter(function(obj) {
        return obj != item;
      });
    },
    handlerUpload(e) {
      let _this = this;
      const file = e.target.files[0];
      let data = {
        file: file,
        folder: _this.folder,
        ext: _this.accept
      };
      this.postUpload(data)
        .then(function(res) {
          let obj = res.data;
          _this.isImg(file,obj);
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    postUpload(data) {
      var _this = this;
      var obj = new FormData();
      for (let item in data) {
        obj.append(item, data[item]);
      }
      let config = {
        headers: { "Content-Type": "multipart/form-data" },
        onUploadProgress: e => {
          var completeProgress = ((e.loaded / e.total) * 100) | 0;
          _this.progress = completeProgress; //加载过程
        }
      };
      return new Promise(function(resolve, reject) {
        axios
          .post(_this.action, obj, config)
          .then(function(res) {
            if (res.data.code == 200) resolve(res);
            else reject(res);
          })
          .catch(function(error) {
            reject(error);
          });
      });
    }
  },
  created() {},
  mounted() {},
  beforeMount() {}
};
</script>
<style scoped>
.myUpload {
  display: flex;
}
.inputfile {
  width: 0px;
  height: 0px;
  opacity: 0;
  overflow: hidden;
  position: absolute;
  z-index: -1;
}
.btn {
  width: 200px;
  height: 200px;
  border-radius: 4px;
  font-size: 3rem;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  border: 1px dashed#ccc;
  color: #ccc;
}
.btn:hover {
  color: #6bc7ff;
  border-color: #6bc7ff;
}
.myUpload-img {
  width: 200px;
  height: 200px;
  margin-right: 10px;
  position: relative;
  border-radius: 4px;
  border: 1px dashed#ccc;
}
.myUpload-img:hover .delete {
  display: flex;
}
.myUpload-img:hover {
  border-color: red;
}
.myUpload-img img {
  width: 100%;
  height: 100%;
}

.myUpload-img .fileLogo {
  color:#adadad;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  position: absolute;
  top: 0;
  bottom: 0;
  text-transform:uppercase;
  font-size:3rem;
}
.myUpload-img .delete {
  width: 100%;
  height: 100%;
  border-radius: 4px;
  position: absolute;
  color: red;
  background: rgba(0, 0, 0, 0.4);
  top: 0;
  bottom: 0;
  display: none;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}
.myUpload-img .delete span {
  background: rgb(216, 216, 216);
  padding: 8px 15px;
  border-radius: 5px;
  box-shadow: 1px 1px 1px #cccccc;
}
</style>