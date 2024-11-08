document.addEventListener('DOMContentLoaded', () => {
    const taskInput = document.getElementById('new-task');
    const addTaskButton = document.getElementById('add-task');
    const taskList = document.getElementById('task-list');

    // Load tasks from LocalStorage or set to empty array if none
    let tasks = JSON.parse(localStorage.getItem('tasks')) || [];

    // Function to render the task list
    const renderTasks = () => {
        taskList.innerHTML = '';
        tasks.forEach((task, index) => {
            const li = document.createElement('li');
            li.classList.toggle('completed', task.completed);

            li.innerHTML = `
                <span>${task.text}</span>
                <button class="complete" data-index="${index}">${task.completed ? 'Undo' : 'Complete'}</button>
                <button class="delete" data-index="${index}">Delete</button>
            `;

            taskList.appendChild(li);
        });
    };

    // Add task to the list
    addTaskButton.addEventListener('click', () => {
        const taskText = taskInput.value.trim();
        if (taskText) {
            tasks.push({ text: taskText, completed: false });
            taskInput.value = '';
            saveTasks();
            renderTasks();
        }
    });

    // Delete or complete task
    taskList.addEventListener('click', (e) => {
        if (e.target.classList.contains('delete')) {
            const index = e.target.getAttribute('data-index');
            tasks.splice(index, 1);
            saveTasks();
            renderTasks();
        }

        if (e.target.classList.contains('complete')) {
            const index = e.target.getAttribute('data-index');
            tasks[index].completed = !tasks[index].completed;
            saveTasks();
            renderTasks();
        }
    });

    // Save tasks to LocalStorage
    const saveTasks = () => {
        localStorage.setItem('tasks', JSON.stringify(tasks));
    };

    // Load tasks initially
    renderTasks();

    // Mock asynchronous function to fetch tasks from a server (simulation)
    const fetchTasksFromServer = async () => {
        try {
            // Simulating a delay
            const response = await new Promise((resolve) =>
                setTimeout(() => resolve([{ text: 'Sample Task from Server', completed: false }]), 1000)
            );
            tasks = response;
            saveTasks();
            renderTasks();
        } catch (error) {
            console.error('Error fetching tasks:', error);
        }
    };

    // Fetch tasks on load (optional)
    fetchTasksFromServer();
});
