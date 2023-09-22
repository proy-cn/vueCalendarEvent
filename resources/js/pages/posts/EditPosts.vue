<template>
    <main class="create-post">
      <div class="container">
        <h1>Edit Post!</h1>
        <!-- success message -->
        <div class="success-msg" v-if="success">
          <i class="fa fa-check"></i>
          Post created successfully
        </div>
        <!-- Contact Form -->
        <div class="contact-form">
          <form @submit.prevent="submit">
            <!-- Title -->
            <label for="title"><span>Title</span></label>
            <input type="text" id="title" v-model="fields.title" />
            <span v-if="errors.title" class="error">{{ errors.title[0] }}</span>
            <br />
            <!-- Drop down -->
            <label for="categories"><span>Choose a category:</span></label>
            <select v-model="fields.category_id" id="categories">
              <option disabled value="">Select option</option>
              <option
                :value="category.id"
                v-for="category in categories"
                :key="category.id"
              >
                {{ category.name }}
              </option>
            </select>
            <span v-if="errors.category_id" class="error">{{
              errors.category_id[0]
            }}</span>
            <br />
            <label for="location"><span>Location</span></label>
            <input type="text" id="location" v-model="fields.location" />
            <span v-if="errors.location" class="error">{{ errors.location[0] }}</span>
            <br />

            <label for="start_date"><span>Star Date</span></label>
            <input type="date" id="start_date" v-model="fields.start_date" />
            <span v-if="errors.start_date" class="error">{{ errors.start_date[0] }}</span>
            <br />

            <label for="start_time"><span>Star Time</span></label>
            <input type="time" id="start_time" v-model="fields.start_time" />
            <span v-if="errors.start_time" class="error">{{ errors.start_time[0] }}</span>
            <br />

            <label for="end_date"><span>End Date</span></label>
            <input type="date" id="end_date" v-model="fields.end_date" />
            <span v-if="errors.end_date" class="error">{{ errors.end_date[0] }}</span>
            <br />
            <label for="end_time"><span>End Time</span></label>
            <input type="time" id="end_time" v-model="fields.end_time" />
            <span v-if="errors.end_time" class="error">{{ errors.end_time[0] }}</span>
            <br />
            <!-- Image -->
            <label for="image"><span>Image</span></label>
            <input type="file" id="image" @input="grabFile" />
            <span v-if="errors.file" class="error">{{ errors.file[0] }}</span>
            <div class="preview">
              <img :src="url" alt="" />
            </div>
            <br />
  
            
  
            <!-- Body-->
            <label for="body"><span>Body</span></label>
            <textarea id="body" v-model="fields.body"></textarea>
            <span v-if="errors.body" class="error">{{ errors.body[0] }}</span>
            <!-- Button -->
            <input class="add-post-btn" type="submit" value="Submit" />
          </form>
        </div>
      </div>
    </main>
  </template>
  
  <script>
  export default {
    props: ["id"],
    data() {
      return {
        success: false,
        fields: {
          category_id: "",
        },
        errors: {},
        url: "",
        categories: [],
      };
    },
  
    methods: {
      grabFile(e) {
        const file = e.target.files[0];
        this.fields.file = file;
        this.url = URL.createObjectURL(file);
        URL.revokeObjectURL(file);
      },
  
      submit() {
        const fd = new FormData();
        fd.append("title", this.fields.title);
        fd.append("category_id", this.fields.category_id);
        if (this.fields.file) {
          fd.append("file", this.fields.file);
        }
        fd.append("body", this.fields.body);
  
        fd.append("_method", "PUT");
  
        axios
          .post(`/api/posts/${this.id}`, fd, {
            headers: {
              "content-type": "multipart/form-data",
            },
          })
          .then((res) => {
            this.$emit("showEditSuccess");
  
            this.$router.push({ name: "DashboardPostsList" });
          })
          .catch((error) => {
            this.errors = error.response.data.errors;
            if (error.response.status === 403) {
              this.$router.push({ name: "DashboardPostsList" });
            }
          });
      },
    },
  
    mounted() {
      axios
        .get("/api/categories")
        .then((response) => (this.categories = response.data))
        .catch((error) => {
          console.log(error);
        });
  
      axios
        .get("/api/posts/" + this.id)
        .then((response) => {
          this.fields = response.data.data;
          this.url = "/" + response.data.data.imagePath;
        })
        .catch((error) => {
          if (error.response.status === 403) {
            this.$router.push({ name: "DashboardPostsList" });
          }
        });
    },
  };
  </script>
  
  <style scoped>
  .create-post {
    background-color: #fff;
    padding: 0 3vw;
  }
  .container input,
  textarea,
  select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-top: 6px;
    margin-bottom: 20px;
    font-size: 16px;
  }
  h1 {
    text-align: center;
    padding: 60px 0 50px 0;
  }
  
  .add-post-btn {
    background-color: black;
    color: white;
    border: none;
    cursor: pointer;
    transition: 0.3s ease;
  }
  
  .add-post-btn:hover {
    transform: translateY(-4px);
  }
  
  .preview img {
    max-width: 100%;
    max-height: 120px;
  }
  </style>