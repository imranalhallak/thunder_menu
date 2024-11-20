<template>
    <div @drop.prevent="onDrop" @dragover.prevent>
        <slot></slot>
    </div>
</template>

<script setup>
import { defineEmits } from 'vue';

const emit = defineEmits(['files-dropped']);

function onDrop(e) {
    const files = [...e.dataTransfer.files];
    emit('files-dropped', files);
}
</script>
<style>
.dropzone {
    border: 2px dashed #ccc;
    padding: 20px;
    text-align: center;
}

.file-preview {
    display: flex;
    align-items: center;
    margin: 10px 0;
}

.file-preview img {
    margin-right: 10px;
}
</style>
