<template>
    <div class="row mt-3">

        <div v-if="loadingPage">
            <div style="height: 100%; width: 100%; position: fixed; z-index: 10000; left: 0; top: 0; background-color: rgba(0,0,0, 0.6); overflow-x: hidden; transition: 0.5s;" class="w-100 d-flex justify-content-center align-items-center h1">
                <span class="spinner-border spinner-border align-middle text-white h1"></span>
            </div>
        </div>
        <!-- <span v-if="loadingPage" class="text-center"><span class="spinner-border spinner-border-sm align-middle ms-2"></span> Working ...</span> -->
        <ul class="pagination mt-3 mb-5">
            <li v-for="(page_link,id) in page_links" :key="id" :id="'pg_id_'+id" class="page-item"
                :class="appliedClass(page_link,'pg_id_'+id)">
                <span v-if="page_link.url==null && page_link.label.includes('Prev')" class="page-link" >Previous</span>
                <span>
                    <a v-if="page_link.url!=null" style="cursor:pointer;" class="page-link" :class="{ 'text-white bg-primary': page_link.active }" @click="$emit('pagenavigate',page_link.url,)">
                        <span v-html="page_link.label"></span>
                    </a>
                </span>
                <span v-if="page_link.url==null && page_link.label.includes('Next')" class="page-link" >Next</span>
            </li>
        </ul>
    </div>
</template>

<script setup>
    defineProps(['page_links','loadingPage']);
    defineEmits(['pagenavigate'])

    const appliedClass=(page_link,id)=>{
        var applied='';
        if(page_link.label.includes('Prev')){
            applied=applied + ' previous ';
        }
        if(page_link.label.includes('Next')){
            applied=applied + ' next ';
        }
        if(page_link.active==true){
            applied=applied + ' active ';
        }
        return applied
    }
</script>
