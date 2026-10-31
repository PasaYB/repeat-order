<script setup>
defineProps({
    value: {
        type: String,
    },
});

const model = defineModel({
    type: String,
    required: true,
});

</script>

<template>
    <input
        class="rounded-md border-gray-300 my-6 shadow-sm input"
        v-model="model"
        placeholder="value"
        ref="input"
    />
</template>

<style scoped>
.input {
  border: none;
  outline: none;
  border-radius: 15px;
  padding: 1em;
  background-color: #ffffff;
  box-shadow: inset 2px 5px 10px rgba(0,0,0,0.3);
  transition: 300ms ease-in-out;
}
</style>
