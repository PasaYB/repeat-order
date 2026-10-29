<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    value: {
        type: String,
    },
});

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
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

.input:focus {
  background-color: white;
  transform: scale(1.05);
  box-shadow: 13px 13px 100px #030303,
             -13px -13px 100px #ffffff;
}
</style>
