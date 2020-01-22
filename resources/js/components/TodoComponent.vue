<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Todo Component</div>

                    <div class="card-body">
                        <input type="text" v-model="newTodo" @keyup.enter="addNewTodo"/>

                        <div v-if="todos && todos.length">
                            <div class="form-group clearfix" v-for="todo of todos" :key="todo.id">
                                <div class="icheck-success d-inline">
                                    <input type="checkbox" :id="'todo'+todo.id" @click="completeTodo(todo.id)"/>
                                    <label :for="'todo'+todo.id" :class="todo.completed ? 'completed' : '' ">
                                        {{todo.todo}}
                                    </label>
                                </div>

                                <span class="text-right">x</span>

                            </div>
                        </div>

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
            axios.get(this.route + '/todos')
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
                axios.post(this.route + '/todos', {
                    body: this.newTodo
                })
                    .then(response => {
                        this.todos.push(response.data);
                        this.newTodo = '';
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
            },
            completeTodo(id) {
                axios.patch(this.route + '/todo/' + id + '/complete')
                    .then(response => {
                        const currentIndex = this.todos.findIndex(o => o.id === id);

                        let todo = _.find(this.todos, function (o) {
                            return o.id === id;
                        });
                        todo.completed = true;

                        this.todos[currentIndex] = todo;
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
            },
            refreshList() {
                // _.filter(users, function(o) { return !o.active; });
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
