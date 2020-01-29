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

                    <div class="row mb-2">
                        <div class="col-1 pr-0">
                            <span><i class="arrow down"></i></span>
                        </div>
                        <div class="col-11 pl-0">
                            <input @keyup.enter.prevent="addNewTodo" class="w-100 no-border todo-input" placeholder="Whats need to be done?"
                                   type="text" v-model="newTodo.todo"/>
                        </div>
                    </div>

                    <hr class="m-0 separator">
                    <div class="mt-2" v-if="filterTodos && filterTodos.length">
                        <div :key="todo.id" class="todo-list clearfix" v-for="(todo, index) of filterTodos">
                            <div @mouseenter="currentTodo = index"
                                 @mouseleave="currentTodo = null">

                                <div class="icheck-success d-inline">
                                    <input :checked="todo.completed" :id="'todo'+todo.id" @click="completeTodo(todo.id)"
                                           type="radio" v-show="filterTodos.actions"/>
                                    <label :for="'todo'+todo.id"></label>
                                </div>

                                <input
                                    @blur="todo.update = false; updateTodo(todo)"
                                    @keyup.enter="todo.update=false; updateTodo(todo)"
                                    v-focus
                                    v-if="todo.update && !todo.completed"
                                    v-model="todo.todo"/>

                                <label :class="todo.completed ? 'completed' : '' " @click="todo.update = true"
                                       v-else>
                                    {{todo.todo}}
                                </label>

                                <a @click.prevent="deleteTodo(todo)" class="float-right cancel" href=""
                                   v-show="currentTodo === index">x</a>
                            </div>
                        </div>

                    </div>

                    <hr class="m-0 separator">
                    <div class="row links" v-if="filterTodos.length || filterBy === 'complete'">
                        <div class="col-3">
                            <a href="#"> <span>{{ filterTodos.length }}</span> {{ (filterTodos.length > 1) ? 'items' :
                                'item' }} left</a>
                        </div>
                        <div class="col-9">
                            <a :class="filterBy === 'all' ? 'active' : '' " @click.prevent="filterBy = 'all'" href="">All</a>
                            <a :class="filterBy === 'active' ? 'active' : '' " @click.prevent="filterBy = 'active'"
                               href="">Active</a>
                            <a :class="filterBy === 'complete' ? 'active' : '' " @click.prevent="filterBy = 'complete'"
                               href="#">Completed</a>
                            <a @click.prevent="clearCompleted()" href="#" v-show="completedTodosCount > 0">Clear
                                Completed</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        mounted() {

        },
        created() {
            this.$store.dispatch("GET_TODOS");
        },
        data: function () {
            return {
                filterBy: 'all',
                currentTodo: null,
            }
        },
        methods: {
            addNewTodo: function () {
                this.$store.dispatch("ADD_TODO");
            },
            updateTodo: function (todo) {
                this.$store.dispatch("UPDATE_TODO", todo);
            },
            deleteTodo: function (todo) {
                this.$store.dispatch("DELETE_TODO", todo);
            },
            completeTodo: function (id) {
                this.$store.dispatch("COMPLETE_TODO", id);
            },
            clearCompleted: function () {
                this.$store.dispatch("CLEAR_COMPLETE_TODO");
            },
        },
        computed: {
            ...mapGetters(["newTodo"]),
            errors() {
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
            },
            completedTodosCount: function () {
                return this.$store.getters.completedTodosCount
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
