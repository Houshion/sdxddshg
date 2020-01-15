<template>
    <div class="header-bar">
        <div class="header-left" href="javascript:void(history.back());" style="display: none;"></div>
        <div class="header-title">{{title}}</div>
    </div>
</template>

<script>
    export default {
        data(){
        	return {
        		title: ''
        	}
        },
        created(){

            this.$bus.on('updateTitle', this.updateTitle);
        },
        methods:{
        	updateTitle(title){
        		this.title = title;
        	}
        }
    }
</script>

<style>

</style>
