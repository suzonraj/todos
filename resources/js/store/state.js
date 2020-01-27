let state = {
    apiUrl: window.Laravel.route,
    todos: [],
    newTodo: {
        todo: '',
        completed: false,
        update: false,
        actions: false,
    },
    updatedTodo: null,
    errors: [],
};
export default state
