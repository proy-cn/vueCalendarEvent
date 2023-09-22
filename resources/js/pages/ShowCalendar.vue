<template>
     <div>
      <FullCalendar  :options="calendarOptions"  ref="fullCalendarRef"/>
    </div>
</template>

<script>
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
export default {
  components: {
    FullCalendar,
  },
  data() {
    return {
      calendarOptions: {
        plugins: [dayGridPlugin],
        initialView: "dayGridMonth", 
        events: [],
      },
    };
  },
  mounted() {
    axios
        .get("/api/calendar-post")
        .then((response) => {
          this.calendarOptions.events = response.data.data;
        })
        .catch((error) => console.log(error));     
  },
};
</script>
