<template>
    <section id="todos">
        <div class="row mx-0">
            <div class="col-lg-12 px-0">
                <div class="logo text-center">
                    <h1>todos</h1>
                </div>
            </div>
            <div class="col-6 col-xs-12 m-auto">
                <div class="main-div">
                    <div class="m-auto">
                            <div class="row mb-2">
                                <div class="col-1 pr-0">
                                    <span><i class="far fa-arrow-down"></i></span>
                                </div>
                                <div class="col-11 pl-0">
                                    <input type="text" v-model="newTodo.todo" @keyup.enter.prevent="addNewTodo" class="w-100 no-border" placeholder="Whats need to be done?"/>
                                </div>
                            </div>

                        <hr class="m-0 separator">
                        <div v-if="filterTodos && filterTodos.length" class="mt-2">
                            <div class="todo-list clearfix" v-for="todo of filterTodos" :key="todo.id" @mouseover="todo.actions = true;$emit('update');" @mouseleave="todo.actions = false;$emit('update');">
                                <div class="icheck-success d-inline">
                                    <input v-show="filterTodos.actions" type="radio" :id="'todo'+todo.id" @click="completeTodo(todo.id)" :checked="todo.completed"/>
                                    <label :for="'todo'+todo.id"></label>
                                </div>

                                <input
                                    v-if="todo.update && !todo.completed"
                                    v-model="todo.todo"
                                    @blur="todo.update = false; updateTodo(todo)"
                                    @keyup.enter="todo.update=false; updateTodo(todo)"
                                    v-focus/>

                                <label v-else @click="todo.update = true"
                                       :class="todo.completed ? 'completed' : '' ">
                                    {{todo.todo}}
                                </label>

                                <a v-show="filterTodos.actions" href="" class="float-right cancel" @click.prevent="deleteTodo(todo.id)">x</a>
                            </div>

                        </div>
                    </div>
                    <hr class="m-0 separator">
                    <div class="footer" v-if="filterTodos.length">
                        <div class="col-lg-12">
                            <div class="left float-left">
                                <a href="#"> <span>{{ filterTodos.length }}</span> {{ (filterTodos.length > 1) ? 'items' :
                                    'item' }} left</a>
                            </div>
                            <div class="right float-right">
                                <a href="" @click.prevent="filterBy = 'all'">All</a>
                                <a href="" @click.prevent="filterBy = 'active'">Active</a>
                                <a href="#" @click.prevent="filterBy = 'complete'">Completed</a>
                                <a href="#" @click.prevent="clearCompleted()">Clear Completed</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import { mapGetters } from "vuex";

    export default {
        mounted() {
            //console.log('Component mounted.')
        },
        created() {
            this.$store.dispatch("GET_TODOS");
        },
        data: function () {
            return {
                filterBy: 'all'
            }
        },
        methods: {
            addNewTodo: function () {
                this.$store.dispatch("ADD_TODO");
            },
            updateTodo: function (todo) {
                this.$store.dispatch("UPDATE_TODO", todo);
            },
            deleteTodo: function (id) {
                this.$store.dispatch("DELETE_TODO", id);
            },
            completeTodo: function (id) {
                this.$store.dispatch("COMPLETE_TODO", id);
            },
            clearCompleted: function () {
                this.$store.dispatch("CLEAR_COMPLETE_TODO");
            },
            // _findTodoIndexById: function (id) {
            //     return this.todos.findIndex(o => o.id === id);
            // },
            // _findTodoById: function (id) {
            //     return _.find(this.todos, function (o) {
            //         return o.id === id;
            //     });
            // },
        },
        computed: {
            ...mapGetters(["newTodo"]),
            errors (){
                return this.$store.getters.errors
            },

            filterTodos: function () {
                if (this.filterBy === 'all') {
                    return this.$store.getters.todos
                }

                if (this.filterBy === 'active') {
                    return this.$store.getters.todos.filter(todo => todo.completed === false);
                }

                if (this.filterBy === 'complete') {
                    return this.$store.getters.todos.filter(todo => todo.completed);
                }

                // return this.todos.filter(t => {
                //     return this.status === 'active' ? t.completed = false : t.completed = true;
                // })
            }
        },
        directives: {
            focus: {
                inserted(el) {
                    el.focus()
                }
            }
        }
    }
</script>
