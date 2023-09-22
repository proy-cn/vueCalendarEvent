<template>
  <div id="backend-view">
    <div class="logout"><a href="#" @click="logout">Log out</a></div>
    <h1 class="heading">Dashboard</h1>
    <span>Hi {{ name }}!</span>
    <div>
      <ShowCalendar />
    </div>    
  </div>
</template>

<script>
import ShowCalendar from "./ShowCalendar.vue";
export default { 
  components: {
    ShowCalendar,
  }, 
  data() {
    return {
      name: "",     
    };
  },
  mounted() {
    axios
      .get("/api/user")
      .then((response) => {
        this.name = response.data.name;       
      })
      .catch((error) => {
        if (error.response.status === 401) {
          this.$emit("updateSidebar");
          localStorage.removeItem("isLoggedIn");
          this.$router.push({ name: "Login" });
        }
      });      
  },

  methods: {
    logout() {
      axios
        .post("/api/logout")
        .then((response) => {
          this.$router.push({ name: "Home" });
          localStorage.removeItem("isLoggedIn");
          this.$emit("updateSidebar");
        })
        .catch((error) => console.log(error));
    },   
  },
};
</script>

<style scoped>
/* dashboard */
#backend-view {
  text-align: center;
  background-color: #f3f4f6;
  height: 100vh;
  padding-top: 15vh;
}

.logout {
  position: absolute;
  top: 30px;
  right: 40px;
}
.heading {
  margin-bottom: 5px;
}

</style>