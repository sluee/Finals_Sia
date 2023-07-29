<template>
    <!-- <div class="mx-auto mt-5 w-80 transform overflow-hidden rounded-lg bg-white dark:bg-slate-800 shadow-md  hover:shadow-lg ">
        <div class="cursor-pointer " @click="open(supplier)">
            <div class="p-4">
            <h2 class="mb-2 text-lg font-medium dark:text-white text-gray-900">{{ supplier.name }}</h2>
            <p class="mb-2 text-base dark:text-gray-300 text-gray-700">{{ supplier.email }}</p>
            <div class="flex items-center">
                <p class="mr-2 text-lg font-semibold text-gray-900 dark:text-white">{{ supplier.phone }}</p>

            </div>
            </div>

        </div>

    </div> -->
    <body class="bg-gray-100">
        <div class="max-w-lg mx-auto my-5 bg-white rounded-lg shadow-md p-5 mr-5">
          <img class="w-32 h-32 rounded-full mx-auto" :src="supplier.picUrl" alt="Profile picture">
          <h2 class="text-center text-2xl font-semibold mt-3">{{ supplier.name }}</h2>
          <p class="text-center text-gray-600 mt-1">{{ supplier.email }}</p>
          <div class="flex justify-center mt-5">
            <a href="#" class="text-blue-500 hover:text-blue-700 mx-3">{{supplier.phone }}</a>
            <!-- <a href="#" class="text-blue-500 hover:text-blue-700 mx-3">LinkedIn</a>
            <a href="#" class="text-blue-500 hover:text-blue-700 mx-3">GitHub</a> -->
          </div>
          <div class="mt-5">
            <h3 class="text-xl font-semibold">Bio</h3>
            <p class="text-gray-600 mt-2">John is a software engineer with over 10 years of experience in developing web and mobile applications. He is skilled in JavaScript, React, and Node.js.</p>
          </div>
        </div>
      </body>

</template>

<script setup>
import { router } from '@inertiajs/vue3';


const props = defineProps({
    supplier: Object
})

function open(product) {
    router.visit('/suppliers/' + supplier.id)
}



</script>


