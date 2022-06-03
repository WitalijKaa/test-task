<script lang="ts">
import axios from 'axios';
import { defineComponent } from 'vue'
import type { PropType } from 'vue'

interface ApiDataProps {
  dir: string
  file: string
}

export default defineComponent({
    props: {
        dir: {
            type: Object as PropType<string>,
            default: '1',
        },
        file: {
            type: Object as PropType<string>,
            required: true,
        },
    },
    data() { return {
        apiData: null as any,
    }},
    mounted() {
        axios.get('http://tt.loc/api/v1/data/1/' + this.file + '.json')
            .then((response) => { this.apiData = response; })
    },
})
</script>

<template lang="pug">
div
    pre apiData
</template>

<style scoped>
</style>
