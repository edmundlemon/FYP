<template>
  <div
    v-if="showLoading"
    class="flex flex-col space-y-4 border rounded-lg border-gray-400 mr-2"
  >
    <Loading class="mt-2 ml-2 mr-2 my-3 fade-in-animation" />
  </div>
  <div v-else-if="slots.length">
    <div class="flex flex-col flex-wrap space-y-5">
      <div
        v-for="(slot, index) in slots"
        :key="slot.id"
        class="fade-in-animation"
      >
        <div
          class="flex flex-col h-1/4 border border-gray-400 bg-gray-100 rounded-lg space-y-2 mr-2 pt-3"
        >
          <div class="flex flex-row items-center h-full">
            <!-- slot number -->
            <div class="mx-5 h-full">
              <p class="h-full font-semibold">{{ index + 1 + "." }}</p>
            </div>

            <!-- slot date -->
            <div class="flex flex-col items-center py-2 mr-10 w-fit">
              <img
                src="../../assets/calendar.png"
                alt="calendar_icon"
                class="w-5 h-5"
                title="Scheduled Date"
              />
              <p class="font-semibold whitespace-nowrap mt-1">
                {{ slot.date }}
              </p>
            </div>

            <!-- slot time -->
            <div class="flex flex-row mr-5">
              <div class="flex flex-col justify-center items-center">
                <div class="flex flex-row items-center justify-center">
                  <svg
                    width="16"
                    height="16"
                    viewBox="0 0 16 16"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    class="w-4 h-4 text-green-500 flex"
                  >
                    <circle cx="8" cy="8" r="6" />
                    <line x1="8" y1="8" x2="12" y2="8" />
                  </svg>
                  <span class="ml-0.5 font-bold text-green-500">{{
                    slot.start_time
                  }}</span>
                </div>
                <div class="flex flex-row items-center justify-center">
                  <svg
                    width="16"
                    height="16"
                    viewBox="0 0 16 16"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    class="w-4 h-4 text-red-500 flex"
                  >
                    <circle cx="8" cy="8" r="6" />
                    <line x1="8" y1="8" x2="12" y2="8" />
                  </svg>
                  <span class="ml-0.5 font-bold text-red-500">{{
                    slot.end_time
                  }}</span>
                </div>
              </div>
            </div>

            <!-- slot topic -->
            <div class="items-center group relative mx-5">
              <div class="flex flex-row items-center w-fit">
                <img
                  src="../../assets/info.png"
                  alt="topic_icon"
                  class="w-5 h-5"
                />
                <p class="ml-1">Topic</p>
              </div>
              <p
                v-if="slot.topic"
                class="w-[15vw] fade-down-animation absolute left-5 top-[4vh] font-semibold hidden group-hover:flex flex-col p-2 bg-gray-200 rounded-xl border-gray-400 border"
              >
                {{ slot.topic }}
              </p>
              <p
                v-else
                class="w-[15vw] fade-down-animation absolute left-5 top-[4vh] font-semibold hidden group-hover:flex flex-col p-2 bg-gray-200 rounded-xl border-gray-400 border"
              >
                {{ "No topic" }}
              </p>
            </div>

            <!-- slot status -->
            <div
              class="flex flex-row items-center justify-start w-fit px-5 mx-5"
            >
              <img
                :src="
                  slot.status === 'Pending'
                    ? 'src/assets/pending.png'
                    : slot.status === 'Student Rescheduled' ||
                      slot.status === 'Student Reschedule Approved'
                    ? 'src/assets/student.png'
                    : slot.status === 'Lecturer Rescheduled' ||
                      slot.status === 'Lecturer Reschedule Approved'
                    ? 'src/assets/lecturer.png'
                    : slot.status === 'Approved'
                    ? 'src/assets/approve.png'
                    : slot.status === 'Rejected'
                    ? 'src/assets/reject.png'
                    : slot.status === 'Completed'
                    ? 'src/assets/completed.png'
                    : 'src/assets/expired.png'
                "
                alt="status_icon"
                class="w-5 h-5"
                title="Status"
              />
              <p
                class="font-semibold ml-2 whitespace-nowrap"
                :class="{
                  'text-yellow-500': slot.status === 'Pending',
                  'text-purple-500':
                    slot.status === 'Student Rescheduled' ||
                    slot.status === 'Lecturer Rescheduled',
                  'text-green-500': slot.status === 'Approved',
                  'text-red-500': slot.status === 'Rejected',
                }"
              >
                {{ slot.status }}
              </p>
            </div>

            <!-- buttons -->
            <div
              class="flex flex-row items-center justify-end w-full pr-5 space-x-2 font-bold"
              v-if="
                (slot.status === 'Pending' &&
                  store.state.role === 'lecturer') ||
                (slot.status === 'Lecturer Rescheduled' &&
                  store.state.role === 'student') ||
                (slot.status === 'Student Rescheduled' &&
                  store.state.role === 'lecturer')
              "
            >
              <button
                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 min-w-[5.5vw]"
                @click.prevent="approveSlot(slot.id)"
              >
                Approve
              </button>
              <button
                class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 min-w-[5.5vw]"
                @click.prevent="rejectSlot(slot.id)"
              >
                Reject
              </button>
            </div>
            <div
              class="flex flex-row items-center justify-end w-full pr-5 space-x-2 font-bold"
              v-else-if="slot.status === 'Completed' && store.state.role === 'student'"
            >
              <button
                class="px-4 py-2 bg-yellow-400 text-white rounded-md hover:bg-yellow-600 min-w-[5.5vw]"
                @click.prevent="console.log('Review button clicked on slot id =>' + slot.id), $emit('review-slot', slot)"

              >
                Review
              </button>
          </div>
          </div>

          <div
            class="flex flex-row pr-5 py-1 bg-gray-200 border-t-gray-300 rounded-b-lg"
          >
            <!-- Slot booked by -->
            <div
              class="flex flex-row items-center border w-full justify-start ml-5"
            >
              <img
                src="../../assets/appointment.png"
                alt="user_icon"
                class="w-5 h-5 mr-2"
                :title="
                  store.state.role === 'lecturer'
                    ? 'Booked by'
                    : 'Consultation by'
                "
              />
              <div v-if="store.state.role === 'lecturer'" class="font-semibold">
                <a :href="'/student/' + slot.student.id"
                  ><p>{{ slot.student.name }}</p></a
                >
              </div>
              <div v-else class="font-semibold">
                <a :href="'/lecturer/' + slot.lecturer.id"
                  ><p>{{ slot.lecturer.name }}</p></a
                >
              </div>

              <p title="Booking Created At" class="ml-2 font-light">
                {{ formatDate(slot.created_at) }}
              </p>
            </div>

            <!-- Updated at -->
            <div class="flex flex-row items-center justify-end w-full">
              <p
                :title="dayjs(updated_at).format('dddd, MMMM D, YYYY h:mm A')"
                class="text-s ml-5 mt-1 whitespace-nowrap"
              >
                {{ "Updated " + formatRelativeTime(slot.updated_at) }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div v-else class="h-full border border-gray-400 rounded mr-2">
    <h2 class="text-xl font-bold text-gray-800 animate-bounce my-5 ml-5">
      Nothing to show here yet.
    </h2>
  </div>
</template>

<script setup>
import { onMounted, ref, defineProps } from "vue";
import store from "../../store";
import axiosInstance from "../../axiosConfig/customAxios";
import Loading from "../Atom/SkeletonLoading.vue";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";

dayjs.extend(relativeTime);

const slots = ref([]);
let showLoading = ref(true);
const props = defineProps({
  page: {
    type: String,
    required: true,
  },
});

function formatRelativeTime(date) {
  return dayjs(date).fromNow();
}

function formatDate(date) {
  return dayjs(date).format("dddd, MMMM D, YYYY");
}

function approveSlot(slotId) {
  if (confirm("Are you sure you want to approve this slot?")) {
    if (store.state.role === "student") {
      axiosInstance
        .put(`/student/approve/${slotId}`)
        .then((response) => {
          console.log(response.data);
          window.location.reload();
        })
        .catch((error) => {
          console.log(error);
        });
    } else {
      axiosInstance
        .put(`/lecturer/approve/${slotId}`)
        .then((response) => {
          console.log(response.data);

          //if time collision detected
          if (response.data.message === "Time Collision") {
            axiosInstance
              .put(`/lecturer/reject/${slotId}`)
              .then((response) => {
                alert("Time Collision Detected! Slot automatically rejected.");
                window.location.reload();
              })
              .catch((error) => {
                console.log(error);
              });
          } else {
            alert("Slot Approved!");
            window.location.reload();
          }
        })
        .catch((error) => {
          console.log(error);
        });
    }
    // window.location.reload();
  }
}

function rejectSlot(slotId) {
  if (confirm("Are you sure you want to reject this slot?")) {
    if (store.state.role === "student") {
      axiosInstance
        .put(`/student/reject/${slotId}`)
        .then((response) => {
          console.log(response.data);
          window.location.reload();
        })
        .catch((error) => {
          console.log(error);
        });
    } else {
      axiosInstance
        .put(`/lecturer/reject/${slotId}`)
        .then((response) => {
          console.log(response.data);
          window.location.reload();
        })
        .catch((error) => {
          console.log(error);
        });
    }
    // window.location.reload();
  }
}

onMounted(async () => {
  switch (props.page) {
    case "Pending":
      if (store.state.role === "student") {
        axiosInstance
          .get("/student/all-pending")
          .then((response) => {
            console.log(response.data.consultation_slots);
            slots.value = response.data.consultation_slots;
            showLoading.value = false;
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        axiosInstance
          .get("/lecturer/all-pending")
          .then((response) => {
            slots.value = response.data.consultation_slots;
            showLoading.value = false;
            console.log(response.data.consultation_slots);
          })
          .catch((error) => {
            console.log(error);
          });
      }
      break;
    case "History":
      if (store.state.role === "student") {
        axiosInstance
          .get("/student/all-past")
          .then((response) => {
            slots.value = response.data.consultation_slots;
            showLoading.value = false;
            console.log(response.data.consultation_slots);
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        axiosInstance
          .get("/lecturer/all-past")
          .then((response) => {
            slots.value = response.data.consultation_slots;
            showLoading.value = false;
            console.log(response.data.consultation_slots);
          })
          .catch((error) => {
            console.log(error);
          });
      }
      break;
    case "Approved":
      if (store.state.role === "student") {
        axiosInstance
          .get("/student/all-approved")
          .then((response) => {
            slots.value = response.data.consultation_slots;
            showLoading.value = false;
            console.log(response.data.consultation_slots);
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        axiosInstance
          .get("/lecturer/all-approved")
          .then((response) => {
            slots.value = response.data.consultation_slots;
            showLoading.value = false;
            console.log(response.data.consultation_slots);
          })
          .catch((error) => {
            console.log(error);
          });
      }
      break;
    case "Rejected":
      if (store.state.role === "student") {
        axiosInstance
          .get("/student/rejected")
          .then((response) => {
            slots.value = response.data.consultation_slots;
            showLoading.value = false;
            console.log(response.data.consultation_slots);
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        axiosInstance
          .get("/lecturer/rejected")
          .then((response) => {
            slots.value = response.data.consultation_slots;
            showLoading.value = false;
            console.log(response.data.consultation_slots);
          })
          .catch((error) => {
            console.log(error);
          });
      }
      break;
    case "Rescheduled":
      if (store.state.role === "student") {
        axiosInstance
          .get("/student/all-rescheduled")
          .then((response) => {
            slots.value = response.data.consultation_slots;
            showLoading.value = false;
            console.log(response.data.consultation_slots);
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        axiosInstance
          .get("/lecturer/all-rescheduled")
          .then((response) => {
            slots.value = response.data.consultation_slots;
            showLoading.value = false;
            console.log(response.data.consultation_slots);
          })
          .catch((error) => {
            console.log(error);
          });
      }
      break;
    case "Expired":
      if (store.state.role === "student") {
        axiosInstance
          .get("/student/all-expired")
          .then((response) => {
            slots.value = response.data.consultation_slots;
            showLoading.value = false;
            console.log(response.data.consultation_slots);
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        axiosInstance
          .get("/lecturer/all-expired")
          .then((response) => {
            slots.value = response.data.consultation_slots;
            showLoading.value = false;
            console.log(response.data.consultation_slots);
          })
          .catch((error) => {
            console.log(error);
          });
      }
      break;
    case "Reschedule Request":
      if (store.state.role === "student") {
        axiosInstance
          .get("/student/reschedule-request")
          .then((response) => {
            slots.value = response.data.consultation_slots;
            showLoading.value = false;
            console.log(response.data.consultation_slots);
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        axiosInstance
          .get("/lecturer/reschedule-request")
          .then((response) => {
            slots.value = response.data.consultation_slots;
            showLoading.value = false;
            console.log(response.data.consultation_slots);
          })
          .catch((error) => {
            console.log(error);
          });
      }
      break;
    case "Completed":
      if (store.state.role === "student") {
        axiosInstance
          .get("/student/all-completed")
          .then((response) => {
            slots.value = response.data.consultation_slots;
            showLoading.value = false;
            console.log(response.data.consultation_slots);
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        axiosInstance
          .get("/lecturer/all-completed")
          .then((response) => {
            slots.value = response.data.consultation_slots;
            showLoading.value = false;
            console.log(response.data.consultation_slots);
          })
          .catch((error) => {
            console.log(error);
          });
      }
      break;
    default:
      break;
  }
});
</script>
