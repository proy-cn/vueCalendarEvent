<template>
     <div id="wrapper">
      <!-- sidebar -->
      <div class="sidebar" :class="{ showOverlay: overlayVisibility }">
        <span class="closeButton" @click="hideOverlay">&times;</span>
        <p class="brand-title"><a href="">Calendar Post</a></p>

        <div class="side-links">
        <ul>
          <li>
            <router-link @click="hideOverlay" :to="{ name: 'Home' }" >Home</router-link>
          </li>         
          <li v-if="!loggedIn">
            <router-link @click="hideOverlay" :to="{ name: 'Register' }" >Register</router-link>
          </li>
          <li v-if="!loggedIn">
            <router-link @click="hideOverlay" :to="{ name: 'Login' }" >Login</router-link>
          </li>
          <li v-if="loggedIn">
            <router-link @click="hideOverlay" :to="{ name: 'Dashboard' }" >Dashboard</router-link >
          </li>
          <li v-if="loggedIn">
            <router-link @click="hideOverlay" :to="{ name: 'CreatePosts' }">Create Posts</router-link>
          </li>
          <li v-if="loggedIn">
            <router-link @click="hideOverlay" :to="{ name: 'DashboardPostsList' }">Posts List</router-link>
          </li>
          <li v-if="loggedIn">
            <router-link @click="hideOverlay" :to="{ name: 'CreateCategories' }">Create Categories</router-link>
          </li>
          <li v-if="loggedIn">
            <router-link @click="hideOverlay" :to="{ name: 'CategoriesList' }">Categories List</router-link>
          </li>

        </ul>
      </div>

        <!-- sidebar footer -->
        <footer class="sidebar-footer">
          <small>&copy; 2023 Calendar Post</small>
        </footer>
      </div>
      <!-- Menu Button -->
      <div class="menuButton" @click="ShowOverlay">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
      </div>
      <!-- main -->
      <main class="container">
        <router-view
          @update-sidebar="updateSidebar"
          @show-edit-success="showEditSuccess"
          :editSuccess="editSuccess"
          :key="$route.path"
        ></router-view>
        
      </main>

      <!-- Main footer -->
      <footer class="main-footer">
        <div>
          <a href=""><i class="fab fa-facebook-f"></i></a>
          <a href=""><i class="fab fa-instagram"></i></a>
          <a href=""><i class="fab fa-twitter"></i></a>
        </div>
        <small>&copy; 2023 Calendar Post</small>
      </footer>
    </div>

  </template>
  <script>
  export default {
    data() {
      return {
        overlayVisibility: false,
        loggedIn: false,
        editSuccess: false,
      };
    },
    methods: {
      ShowOverlay() {
        this.overlayVisibility = true;
      },

      hideOverlay() {
        this.overlayVisibility = false;
      },

      updateSidebar() {
        this.loggedIn = !this.loggedIn;
      },

      showEditSuccess() {
        this.editSuccess = true;
      },      
    },

    mounted() {
      if (localStorage.getItem("isLoggedIn")) {
        this.loggedIn = true;
      } else {
        this.loggedIn = false;
      }
    },
  };
  </script>
  <style scoped>
    .showOverlay {
      width: 100%;
      z-index: 5;
    }
  </style>