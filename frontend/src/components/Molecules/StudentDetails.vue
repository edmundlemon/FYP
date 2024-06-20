<template>
  <div
    class="space-y-3 py-12 border-b border-gray-500 border-opacity-50 w-full h-fit flex flex-col justify-center items-center green-bg rounded-t-lg shadow-lg"
  >
    <img
      :src="student.photo"
      alt="Descriptive Alt Text"
      class="max-h-40 max-w-40 object-contain rounded-lg shadow-xl ring-2 ring-white"
    />
    <div class="flex flex-col items-center justify-center">
      <h1 class="text-4xl font-bold my-1.5">{{ student.name }}</h1>

      <div class="flex flex-row contact-container space-x-12">
        <!-- Email -->
        <div class="flex flex-row text-lg my-1.5 items-center">
          <img
            title="Email"
            class="icons w-6 h-6 mr-2"
            src="../../assets/email.png"
            alt=""
          /><a :href="'mailto:' + student.email"
            ><span>{{ student.email }}</span></a
          >
        </div>

        <!-- Programme -->
        <div class="flex flex-row text-lg my-1.5 items-center">
          <img
            title="Programme"
            class="icons w-6 h-6 mr-2"
            src="../../assets/education-program.png"
            alt=""
          />
          <span>{{ student.program }}</span>
        </div>

        <!-- Faculty -->
        <div class="flex flex-row text-lg my-1.5 items-center">
          <img
            title="Faculty"
            class="icons w-6 h-6 mr-2"
            src="../../assets/faculty.png"
            alt=""
          /><span>{{ student.faculty }}</span>
        </div>

        <!-- User since -->
        <div class="flex flex-row text-lg my-1.5 items-center">
          <img
            title="User since"
            class="icons w-6 h-6 mr-2"
            src="../../assets/clock.png"
            alt=""
          /><span>{{ new Date(student.created_at).toLocaleDateString() }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    student: Object,
    required: true,
  },
};
</script>
