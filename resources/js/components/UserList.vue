<template>
    <div>
        <h1>قائمة المستخدمين</h1>
        <ul>
            <li v-for="user in users" :key="user.id">{{ user.name }} - {{ user.email }}</li>
        </ul>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';

export default {
    setup() {
        const users = ref([]);

        const fetchUsers = async () => {
            const response = await fetch('/dashboard/User/list');
            users.value = await response.json();
        };

        onMounted(fetchUsers);

        return { users };
    },
};
</script>
