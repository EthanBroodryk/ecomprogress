<script setup>
import { useForm,usePage } from '@inertiajs/vue3'
const user = usePage().props.auth.user;

const form = useForm({
  name: null,
  avatar: null,
  user_id: user.id,
})

console.log(user.id)
</script>

<template>
  <form @submit.prevent="form.post(route('profile.uploadpic'))" class="mt-6 space-y-6">
    <input style="color:aquamarine" type="text" v-model="form.name" />
    <input style="color:red" type="file" @input="form.avatar = $event.target.files[0]" />
    <input type="hidden" @input="form.user_id = user.id"/>
    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
      {{ form.progress.percentage }}%
    </progress>
    <!-- <button type="submit">Submit</button> -->
    <button type="submit"
        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
    >
        Submit
    </button>
  </form>
</template>