<!-- ModalDialog.vue -->
<script setup>
  const emit = defineEmits(['confirm', 'cancel'])
</script>

<template>
  <div>
    <!-- The modal component body -->
    <button @click="emit('confirm')">Confirm</button>
    <button @click="emit('cancel')">Cancel</button>
  </div>
</template>