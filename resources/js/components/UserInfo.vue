<template>
  <div>
    <span class="text-muted">{{ postDate }}</span>
    <div class="media mt-2 d-flex justify-content-end">
      <a :href="user.url" class="pr-2">
        <img :src="user.avatar" alt="" />
      </a>
      <div class="mt-1">
        <a :href="user.url">{{ user.name }}</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["model", "label"], // <user-info model="..." label="...."></user-info>
  computed: {
    postDate() {
      return this.label + " " + this.model.created_date;
    },
  },
  data() {
    return {
      user: this.model.user,
    };
  },
};
</script>
