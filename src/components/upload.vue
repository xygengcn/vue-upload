<template>
  <div class="myUpload">
    <div class="myUpload-img" v-for="(item,index) in mydata" :key="index">
      <img :src="item.src" v-if="type=='image'" />
      <div class="fileLogo" v-else>{{item.ext}}</div>
      <div class="delete" @click="del(item)">
        <i class="icon-delete">+</i>
      </div>
    </div>
    <label :for="id" class="btn" v-if="limit?mydata.length < limit:true">
      <i class="icon-add">+</i>
      <input type="file" :id="id" class="inputfile" @change="handlerUpload($event)" :accept="accept" />
    </label>
  </div>
</template>

<script>
  import axios from "axios";
  export default {
    components: {},
    props: ["id", "limit", "action", "folder", "ext", "size", "data", "type", "autoName"],
    data() {
      return {
        mydata: this.data ? this.data.slice() : [],
        progress: 0,
        accept: this.ext != null ? this.ext.join() : [".gif", ".jpeg", ".jpg", ".png", ".JPG", ".bmp"]
      }
    },
    watch: {
      mydata: {
        handler(newVal, oldVal) {
          this.$emit("getList", newVal, oldVal);
        },
        immediate: true
      },
      progress: {
        handler(newVal) {
          this.$emit("getProgress", newVal);
        },
        immediate: true
      }
    },
    methods: {
      isImg(file, obj) {
        var _this = this;
        if (_this.type == "image") {
          let fileReader = new FileReader();
          fileReader.readAsDataURL(file);
          fileReader.onload = function (ev) {
            obj.src = ev.target.result;
            _this.mydata.push(obj);
          };
        } else {
          this.mydata.push(obj);
        }
      },
      del(item) {
        this.mydata = this.mydata.filter(function (obj) {
          return obj != item;
        });
      },
      handlerUpload(e) {
        let _this = this;
        const file = e.target.files[0];
        let data = {
          file: file,
          folder: _this.folder,
          ext: _this.accept,
          size: _this.size,
          autoName: _this.autoName == 0 ? _this.autoName : 1
        };
        this.postUpload(data)
          .then(function (res) {
            let obj = res.data;
            _this.isImg(file, obj);
          })
          .catch(function (error) {
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
          headers: {
            "Content-Type": "multipart/form-data"
          },
          onUploadProgress: e => {
            var completeProgress = ((e.loaded / e.total) * 100) | 0;
            _this.progress = completeProgress; //上传过程
          }
        };
        return new Promise(function (resolve, reject) {
          axios
            .post(_this.action, obj, config)
            .then(function (res) {
              if (res.data.code == 200) resolve(res);
              else reject(res);
            })
            .catch(function (error) {
              reject(error);
            });
        });
      }
    }
  };
</script>
<style scoped>
  i {
    font-style: normal;
  }

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
    color: #adadad;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    position: absolute;
    top: 0;
    bottom: 0;
    text-transform: uppercase;
    font-size: 3rem;
  }

  .myUpload-img .delete {
    width: 100%;
    height: 100%;
    border-radius: 4px;
    position: absolute;
    background: rgba(0, 0, 0, 0.4);
    top: 0;
    bottom: 0;
    display: none;
    align-items: center;
    justify-content: center;
    cursor: pointer;
  }

  .icon-delete {
    color: red;
    font-size: 3rem;
    transform: rotate(45deg);
  }
</style>