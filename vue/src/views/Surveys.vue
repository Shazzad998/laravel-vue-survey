<template>
  <PageComponent>
    <template v-slot:header>
      <div class="flex items-center justify-between">
        <h1 class="text-3xl text-gray-900 font-bold">Surveys</h1>
        <router-link
          :to="{ name: 'SurveyCreate' }"
          class="flex items-center justify-between bg-gray-700 hover:bg-gray-800 text-white px-8 py-2 rounded-md text-sm"
          >Add New Survey
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4 ml-2"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 4v16m8-8H4"
            /></svg
        ></router-link>
      </div>
    </template>
    <div v-if="surveys.loading" class="flex justify-center">Loading.....</div>
    <div v-else>
      <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3">
        <SurveyListItem
          v-for="(survey, index) in surveys.data"
          :key="survey.id"
          :survey="survey"
          class="opacity-0 animate-fade-in-left"
          :style="{ animationDelay: `${index * 0.1}s` }"
          @delete="deleteSurvey(survey)"
        />
      </div>

      <div class="flex justify-end mt-16">
        <nav
          class="relative inline-flex z-0 justify-center rounded-md shadow-sm"
        >
          <a
            href="#"
            v-for="(link, i) in surveys.links"
            :key="i"
            v-html="link.label"
            :disabled="!link.url"
            aria-current="page"
            @click.prevent="getForPage(link)"
            class="relative inline-flex items-center px-4 py-2 text-sm font-medium whitespace-nowrap"
            :class="[
              link.active
                ? 'z-10 bg-indigo-50 border border-indigo-500 text-indigo-700'
                : 'bg-white border border-gray-300 text-gray-600 hover:bg-gray-50',
              i === 0 ? 'rounded-l-md' : '',
              i === surveys.links.length - 1 ? 'rounded-r-md' : '',
            ]"
          ></a>
        </nav>
      </div>
    </div>
  </PageComponent>
</template>

<script setup>
import PageComponent from "../components/PageComponent.vue";
import store from "../store";
import { computed } from "vue";
import SurveyListItem from "../components/SurveyListItem.vue";

const surveys = computed(() => store.state.surveys);
store.dispatch("getSurveys");

function deleteSurvey(survey) {
  if (confirm("Are you sure you want to delete this survey?")) {
    //delete survey
    store.dispatch("deleteSurvey", survey.id).then(() => {
      store.commit("notify", {
        type: "error",
        message: "Survey was successfully deleted",
      });
      store.dispatch("getSurveys");
    });
  }
}

function getForPage(link) {
  if (!link.url || link.active) {
    return;
  }
  store.dispatch("getSurveys", { url: link.url });
}
</script>
