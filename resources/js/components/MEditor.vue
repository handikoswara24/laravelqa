<template>
  <div class="card">
    <div class="card-header">
      <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" :href="'#write' + keyId"
            >Write</a
          >
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" :href="'#preview' + keyId"
            >Preview</a
          >
        </li>
      </ul>
    </div>
    <div class="card-body tab-content">
      <div class="tab-pane active" :id="'write' + keyId">
        <slot></slot>
      </div>
      <div :id="'preview' + keyId" class="tab-pane">
        <div>
          <markdown-it-vue :content="body" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import autosize from "autosize";

export default {
  props: ["body", "keyId"],
  computed: {
    // preview() {
    //   return md.render(this.body);
    // },
  },
  updated() {
    autosize(this.$el.querySelector("textarea"));
  },
  mounted() {
    console.log(this.keyId);
    autosize(this.$el.querySelector("textarea"));
  },
};
</script>