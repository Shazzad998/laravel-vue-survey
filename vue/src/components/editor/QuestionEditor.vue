<template>
  <div>
    <!-- Question index -->
    <div class="flex items-center justify-between">
      <h3 class="text-lg font-bold">{{ index + 1 }}. {{ model.question }}</h3>

      <div class="flex items-center">
        <!-- Add new question -->
        <button
          type="button"
          @click="addQuestion()"
          class="flex items-center text-xs py-1 px-3 mr-2 rounded-sm text-white bg-gray-600 hover:bg-gray-700"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 6v6m0 0v6m0-6h6m-6 0H6"
            />
          </svg>
          Add
        </button>
        <!-- Delete question -->
        <button
          type="button"
          @click="deleteQuestion()"
          class="flex items-center text-xs py-1 px-3 rounded-sm border border-transparent text-red-500 hover:border-red-600"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
            />
          </svg>
          Delete
        </button>
      </div>
    </div>

    <!-- Question index -->
    <div class="grid gap-3 grid-cols-12">
      <!-- Question -->
      <div class="mt-3 col-span-9">
        <label
          :for="'question_text_' + model.data"
          class="block text-sm font-medium Otext-gray-700"
          >Question Text</label
        >
        <input
          type="text"
          :name="'question_text_' + model.data"
          v-model="model.question"
          @change="dataChange"
          :id="'question_text_' + model.data"
          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
        />
      </div>
      <!-- Question Type -->
      <div class="mt-3 col-span-3">
        <label
          for="question_type"
          class="block text-sm font-medium Otext-gray-700"
        >
          Select Question Type
        </label>

        <select
          id="question_type"
          name="question_type"
          v-model="model.type"
          @change="typeChange"
          class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none O focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        >
          <option
            v-for="type in questionTypes"
            :key="type"
            :value="type"
            class="first-letter:uppercase"
          >
            {{ type }}
          </option>
        </select>
      </div>
    </div>

    <!-- Question Description -->
    <div class="mt-3 col-span-9">
      <label
        :for="'question_description_' + model.id"
        class="block text-sm font-medium Otext-gray-700"
      >
        Description
      </label>

      <textarea
        :name="'question_description_' + model.id"
        v-model="model.description"
        @change="dataChange"
        :id="'question_description_' + model.id"
        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
      />
    </div>

    <!-- Data -->
    <div>
      <div v-if="shouldHaveOptions()" class="mt-2">
        <h4
          class="text-sm font-semibold mb-1 flex justify-between items-center"
        >
          Options

          <button
            type="button"
            @click="addOption()"
            class="flex items-center text-xs py-1 px-2 rounded-sm text-white bg-gray-600 hover:bg-gray-700"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-6 w-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 6v6m0 0v6m0-6h6m-6 0H6"
              />
            </svg>
            Add Option
          </button>
        </h4>

        <div
          v-if="!model.data.options.length"
          class="text-xs text-gray-600 text-center py-3"
        >
          You don't have any options defined
        </div>

        <div
          v-for="(option, index) in model.data.options"
          :key="option.uuid"
          class="flex items-center mb-1"
        >
          <span class="w-6 text-sm"> {{ index + 1 }}. </span>
          <input
            type="text"
            v-model="option.text"
            @change="dataChange"
            class="w-full rounded-sm py-1 px-2 text-xs border I border-gray-300 Ofocus:border-indigo-500"
          />

          <button
            type="button"
            @click="removeOption(option)"
            class="h-6 w-6 rounded-full flex items-center justify-center border border-transparent transition-colors hover:border-red-100"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                fill-rule="evenodd"
                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                clip-rule="evenodd"
              />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <hr class="my-10" />
  </div>
</template>
<script setup>
import { ref } from "vue";
import store from "../../store";
import { computed } from "vue";
import { v4 as uuidv4 } from "uuid";

const props = defineProps({
  question: Object,
  index: Number,
});

const emit = defineEmits(["change", "addQuestion", "deleteQuestion"]);

// Re-create the whole question data to avoid unintentional reference change
const model = ref(JSON.parse(JSON.stringify(props.question)));

// Get question typs from vuex
const questionTypes = computed(() => store.state.questonTypes);

// Checks if the question should have options
function shouldHaveOptions() {
  return ["select", "radio", "checkbox"].includes(model.value.type);
}

function getOptions() {
  return model.value.data.options;
}

function setOptions(options) {
  model.value.data.options = options;
}

function addOption() {
  setOptions([...getOptions(), { uuid: uuidv4(), text: "" }]);
  dataChange();
}

function removeOption(op) {
  setOptions(getOptions().filter((opt) => opt !== op));
  dataChange();
}

function typeChange() {
  if (shouldHaveOptions()) {
    setOptions(getOptions() || []);
  }
  dataChange();
}

// emits the data change
function dataChange() {
  const data = JSON.parse(JSON.stringify(model.value));
  if (!shouldHaveOptions()) {
    delete data.data.options;
  }

  emit("change", data);
}

function addQuestion() {
  emit("addQuestion", props.index + 1);
}

function deleteQuestion() {
  emit("deleteQuestion", props.question);
}
</script>
