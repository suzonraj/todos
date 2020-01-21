<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Todo Component</div>

                    <div class="card-body">
                        <input type="text" v-model="newTodo" @keyup.enter="addNewTodo"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            //console.log('Component mounted.')
        },
        props: {
            route: {type: String, required: true}
        },
        data: function () {
            return {
                newTodo: '',
                errors: [],
            }
        },
        methods: {
            addNewTodo() {
                axios.post(this.route, {
                    body: this.newTodo
                })
                    .then(response => {
                        console.log(response);
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
            }
        },
        // watch: {
        //     new_task: {
        //         immediate: true,
        //         handler() {
        //             this.addNewTask();
        //         }
        //     }
        // }
    }
</script>
