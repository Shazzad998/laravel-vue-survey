<template>
  <fieldset class="mb-4">
    <div>
      <legend class="text-base font-medium Otext-gray-900">
        {{ index + 1 }}. {{ question.question }}
      </legend>
      <p class="text-gray-500 text-sm">
        {{ question.description }}
      </p>
    </div>
    <div class="mt-3">
      <div v-if="question.type === 'select'">
        <select
          :value="modelValue"
          @change="emits('update:modelValue', $event.target.value)"
          class="mt-1 block w-full py-2 px-3 border border-gray-300 shadow-sm- focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-white rounded-md sm:text-sm"
        >
          <option value="">Please Select</option>
          <option
            v-for="option in question.data.options"
            :key="option.uuid"
            :value="option.text"
            class="first-letter:uppercase"
          >
            {{ option.text }}
          </option>
        </select>
      </div>
      <div v-else-if="question.type === 'radio'">
        <div
          v-for="option in question.data.options"
          :key="option.uuid"
          class="flex items-center"
        >
          <input
            type="radio"
            :id="option.uuid"
            :name="'question' + question.id"
            :value="option.text"
            @change="emits('update:modelValue', $event.target.value)"
            class="focus:ring-indigo-400 w-4 h-4 text-indigo-500 border border-gray-300"
          />

          <label
            :for="option.uuid"
            class="ml-3 block text-sm font-medium text-gray-700"
          >
            {{ option.text }}
          </label>
        </div>
      </div>
      <div v-else-if="question.type === 'checkbox'">
        <div
          v-for="option in question.data.options"
          :key="option.uuid"
          class="flex items-center"
        >
          <input
            type="checkbox"
            :id="option.uuid"
            v-model="model[option.text]"
            @change="onCheckboxChange"
            class="focus:ring-indigo-400 w-4 h-4 text-indigo-500 border border-gray-300 rounded"
          />

          <label
            :for="option.uuid"
            class="ml-3 block text-sm font-medium text-gray-700"
          >
            {{ option.text }}
          </label>
        </div>
      </div>
      <div v-else-if="question.type === 'text'">
        <input
          type="text"
          :value="modelValue"
          @input="emits('update:modelValue', $event.target.value)"
          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
        />
      </div>
      <div v-else-if="question.type === 'textarea'">
        <textarea
          :value="modelValue"
          @input="emits('update:modelValue', $event.target.value)"
          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
        ></textarea>
      </div>
    </div>
  </fieldset>
  <hr class="mb-4" />
</template>

<script setup>
import { ref } from "@vue/reactivity";

const { question, index, modelValue } = defineProps({
  question: Object,
  index: Number,
  modelValue: [String, Array],
});

const emits = defineEmits(["update:modelValue"]);

let model;
if (question.type === "checkbox") {
  model = ref({});
}

function onCheckboxChange($event) {
  const selectedOptions = [];
  for (let text in model.value) {
    if (model.value[text]) {
      selectedOptions.push(text);
    }
  }

  emits("update:modelValue", selectedOptions);
}
</script>
