document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("userForm");
    const nameInput = document.getElementById("name");
    const emailInput = document.getElementById("email");
    const userList = document.getElementById("usersBody");
    const resetBtn = document.getElementById("resetBtn");

    function loadUsers() {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "get_users.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const users = JSON.parse(xhr.responseText);
                    renderUsers(users);
                } else {
                    alert("Error occurred while loading users");
                }
            }
        };
        xhr.send();
    }

    loadUsers();

    form.addEventListener("submit", function(event) {
        event.preventDefault();
        addUser(nameInput.value, emailInput.value);
        nameInput.value = "";
        emailInput.value = "";
    });

    resetBtn.addEventListener("click", function() {
        resetUsers();
    });

    function renderUsers(users) {
        userList.innerHTML = "";
        users.forEach(user => {
            const newRow = document.createElement("tr");
            newRow.innerHTML = `
                <td>${user.name}</td>
                <td>${user.email}</td>
                <td>€${user.share}</td>
            `;
            userList.appendChild(newRow);
        });
    }

    function addUser(name, email) {
        if (!name || !email) {
            alert("Please fill in all fields");
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "save_user.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        loadUsers();
                    } else {
                        alert(response.message);
                    }
                } else {
                    alert("Error occurred while adding user");
                }
            }
        };
        xhr.send(`name=${encodeURIComponent(name)}&email=${encodeURIComponent(email)}`);
    }

    function resetUsers() {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "reset_users.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    loadUsers();
                } else {
                    alert("Error occurred while resetting users");
                }
            }
        };
        xhr.send();
    }
});
