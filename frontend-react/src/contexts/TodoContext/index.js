import React, { useContext, useState } from 'react';
import PropTypes from 'prop-types';
import axios from '../../config/axios';
import { useAuth, useAuthUpdate } from '../AuthContext';
import refreshToken from '../../requests/refreshToken';
import { addMinutes, subMinutes } from 'date-fns';

const TodoContext = React.createContext();
const TodoGetContext = React.createContext();
const TodoCreateContext = React.createContext();
const TodoDeleteContext = React.createContext();
const TodoEditContext = React.createContext();

export function useTodos () {
    return useContext(TodoContext);
}

export function useGetTodos () {
    return useContext(TodoGetContext);
}

export function useCreateTodo () {
    return useContext(TodoCreateContext);
}

export function useDeleteTodo () {
    return useContext(TodoDeleteContext);
}

export function useEditTodo () {
    return useContext(TodoEditContext);
}

export default function TodoProvider ({ children }) {
    const [todos, setTodos] = useState([]);
    const auth = useAuth();
    const updateAuth = useAuthUpdate();

    const fixDateOffset = (date) => {
        return addMinutes(date, new Date().getTimezoneOffset()).getTime();
    };

    const updateLocalTodos = (todos) => {
        localStorage.setItem('todos', JSON.stringify(todos));
        setTodos(todos);
    };

    async function getTodos () {
        if (auth === null) {
            const todos = JSON.parse(localStorage.getItem('todos')) ?? [];
            setTodos(todos);

            return;
        }

        await refreshToken(auth, updateAuth);

        const response = await axios.get('/todos')
            .then(response => response.data)
            .then(data => data);

        response.sort((td1, td2) => td1.id - td2.id);
        const todos = response.map(function (todo) {
            todo.date = todo.date && subMinutes(todo.date, new Date().getTimezoneOffset()).getTime();
            todo.reminder = todo.reminder && subMinutes(todo.reminder, new Date().getTimezoneOffset()).getTime();

            return todo;
        });

        setTodos(todos);
    }

    async function createTodo (todo) {
        if (auth === null) {
            todo.id = Math.floor(Math.random() * Math.pow(10, 7));
            updateLocalTodos([...todos, todo]);

            return;
        }

        const date = todo.date ? fixDateOffset(todo.date) : null;
        const reminder = todo.reminder ? fixDateOffset(todo.reminder) : null;

        const payload = {
            name: todo.name,
            description: todo.description,
            date: date,
            reminder: reminder,
            isDone: todo.isDone
        };

        await refreshToken(auth, updateAuth);

        const response = await axios.post('/todos', JSON.stringify(payload))
            .then(response => response.data)
            .then(data => data);

        todo.id = response.id;

        setTodos([...todos, todo]);
    }

    async function deleteTodo (todo) {
        const newTodos = todos.filter((td) => td.id !== todo.id);

        if (auth === null) {
            updateLocalTodos(newTodos);

            return;
        }

        await refreshToken(auth, updateAuth);

        await axios.delete('/todos/' + todo.id)
            .then(response => response.data)
            .then(data => data);

        setTodos(newTodos);
    }

    async function editTodo (editedTodo) {
        const newTodos = todos.map(todo =>
            todo.id === editedTodo.id ? editedTodo : todo
        );

        if (auth === null) {
            updateLocalTodos(newTodos);

            return;
        }

        const date = editedTodo.date ? fixDateOffset(editedTodo.date) : null;
        const reminder = editedTodo.reminder ? fixDateOffset(editedTodo.reminder) : null;

        const payload = {
            name: editedTodo.name,
            description: editedTodo.description,
            date: date,
            reminder: reminder,
            isDone: editedTodo.isDone
        };
        await refreshToken(auth, updateAuth);

        await axios.put('/todos/' + editedTodo.id, JSON.stringify(payload))
            .then(response => response.data)
            .then(data => data);

        setTodos(newTodos);
    }

    return (
        <TodoContext.Provider value={todos}>
            <TodoGetContext.Provider value={getTodos}>
                <TodoCreateContext.Provider value={createTodo}>
                    <TodoDeleteContext.Provider value={deleteTodo}>
                        <TodoEditContext.Provider value={editTodo}>
                            {children}
                        </TodoEditContext.Provider>
                    </TodoDeleteContext.Provider>
                </TodoCreateContext.Provider>
            </TodoGetContext.Provider>
        </TodoContext.Provider>
    );
}

TodoProvider.propTypes = {
    children: PropTypes.oneOfType([
        PropTypes.arrayOf(PropTypes.node),
        PropTypes.node
    ]).isRequired
};
