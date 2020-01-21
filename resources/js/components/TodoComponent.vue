<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Todo Component</div>

                    <div class="card-body">
                        <input type="text" v-model="newTodo" @keyup.enter="addNewTodo"/>

                        <ul v-if="todos && todos.length">
                            <li v-for="todo of todos" :key="todo.id" :class="todo.completed ? 'completed' : '' ">
                                <p><strong>{{todo.todo}}</strong></p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            route: {type: String, required: true}
        },
        mounted() {
            //console.log('Component mounted.')
        },
        // Fetches todos when the component is created.
        created() {
            axios.get(this.route)
                .then(response => {
                    this.todos = response.data.data;
                })
                .catch(e => {
                    this.errors.push(e)
                })
        },
        data: function () {
            return {
                newTodo: '',
                todos: [],
                errors: [],
            }
        },
        methods: {
            addNewTodo() {
                axios.post(this.route, {
                    body: this.newTodo
                })
                    .then(response => {
                        this.todos.push(response.data);
                        this.newTodo = '';
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
