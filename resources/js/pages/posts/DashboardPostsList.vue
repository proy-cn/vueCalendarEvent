<template>
  <div class="categories-list">
    <h1>Posts List</h1>
    <!-- success message -->
    <div class="success-msg" v-if="success">
      <i class="fa fa-check"></i>
      Post deleted successfully
    </div>
    <div class="success-msg" v-if="editSuccess">
      <i class="fa fa-check"></i>
      Post edited successfully
    </div>
    <table id="post_list">
      <thead>
        <tr>
          <th>S.N</th>
          <th>Title</th>
          <th>Location</th>
          <th>Start Date</th>
          <th>Start Time</th>
          <th>End Date</th>
          <th>End Time</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(post, index) in posts" :key="post.id">
          <td>{{ index + 1 }}</td>
          <td>{{ post.title }}</td>
          <td>{{ post.location }}</td>
          <td>{{ post.start_date }}</td>
          <td>{{ formatTime(post.start_time) }}</td>
          <td>{{ post.end_date }}</td>
          <td>{{ formatTime(post.end_time) }}</td>
          <td>
            <router-link
              class="edit-link"
              :to="{ name: 'EditPosts', params: { id: post.id  } }"
              >Edit</router-link
            >
            <input
              type="button"
              value="Delete"
              class="delete-btn"
              @click="destroy(post.id)"
            />
          </td>
        </tr>
      </tbody>
    </table>
    <!-- <div class="item" v-for="(post, index) in posts" :key="post.id">
      <span>{{ index + 1 }}.</span>
      <p>{{ post.title }}</p>
      <div>
        <router-link
          class="edit-link"
          :to="{ name: 'EditPosts', params: { id: post.id } }"
          >Edit</router-link
        >
      </div>

      <input
        type="button"
        value="Delete"
        class="delete-btn"
        @click="destroy(post.id)"
      />
    </div> -->
    <div class="index-categories">
      <router-link :to="{ name: 'CreatePosts' }"
        >Create post<span>&#8594;</span></router-link
      >
    </div>
  </div>
</template>
<script>
import $ from "jquery"
import DataTable from "datatables.net-dt"
// import "datatables.net-dt/js/dataTables.dataTables.min.js"
import "datatables.net-dt/css/jquery.dataTables.min.css"
export default {
  props: ["editSuccess"],
  emits: ["updateSidebar"],
  data() {
    return {
      posts: [],
      success: false,
    };
  },
  methods: {
    destroy(id) {
      axios
        .delete(`/api/posts/${id}`)
        .then(() => {
          this.fetchPosts();
          this.success = true;
          setTimeout(() => {
            this.success = false;
          }, 2500);
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    },

    fetchPosts() {
      axios
        .get("/api/dashboard-posts")
        .then((response) => (this.posts = response.data.data)
        (
            setTimeout(() => {
              new DataTable('#post_list')
              $('#post_list').show()
            }, 1000)
        ))
        .catch((error) => {
          console.log(error);
        });
    },
    formatTime(time) {
      // Split the time string into hours and minutes
      const [hours, minutes] = time.split(':');
      
      // Convert to 12-hour format with AM/PM
      const formattedTime = (parseInt(hours) % 12) + ':' + minutes + ' ' + (parseInt(hours) >= 12 ? 'PM' : 'AM');
      
      return formattedTime;
    }
  },

  mounted() {
    this.fetchPosts();
  },
};
</script>

<style scoped >
.categories-list {
  min-height: 100vh;
  background: #fff;
}

.categories-list h1 {
  font-weight: 300;
  padding: 50px 0 30px 0;
  text-align: center;
}

.categories-list .item {
  display: flex;
  justify-content: right;
  align-items: center;
  max-width: 300px;
  margin: 0 auto !important;
}

.categories-list .item p {
  font-size: 16px;
}

.categories-list .item p,
.categories-list .item div,
.categories-list .item {
  margin: 15px 8px;
}

.categories ul li {
  list-style: none;
  background-color: #494949;
  margin: 20px 5px;

  border-radius: 15px;
}

.categories ul {
  display: flex;
  justify-content: center;
}

.categories a {
  color: white;
  padding: 10px 20px;
  display: inline-block;
}

.create-categories a,
.index-categories a {
  all: revert;
  margin: 20px 0;
  display: inline-block;
  text-decoration: none;
}

.create-categories a span,
.index-categories a span {
  font-size: 22px;
}

.index-categories {
  text-align: center;
}
</style>