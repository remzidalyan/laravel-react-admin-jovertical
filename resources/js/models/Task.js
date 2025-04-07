import axios from 'axios';

export default class Task {
    /**
     * Fetch all Task list.
     *
     * @param {object} params
     *
     * @return {object}
     */
    static async getAll(params = {}) {
        const response = await axios.get('/api/v1/tasks/all', {
            params,
        });

        if (response.status !== 200) {
            return {};
        }

        return response.data.data;
    }

    /**
     * Fetch a paginated Task list.
     *
     * @param {object} params
     *
     * @return {object}
     */
    static async paginated(params = {}) {
        const response = await axios.get('/api/v1/tasks', {
            params,
        });

        if (response.status !== 200) {
            return {};
        }

        return response.data.data;
    }

    /**
     * Store a new Task.
     *
     * @param {object} attributes
     *
     * @return {object}
     */
    static async store(attributes) {
        const response = await axios.post('/api/v1/tasks', attributes);

        if (response.status !== 201) {
            return {};
        }

        return response.data;
    }

    /**
     * Show a Task.
     *
     * @param {number} id
     *
     * @return {object}
     */
    static async show(id) {
        const response = await axios.get(`/api/v1/tasks/${id}`);

        if (response.status !== 200) {
            return {};
        }

        return response.data;
    }

    /**
     * Update a Task.
     *
     * @param {number} id
     * @param {object} attributes
     *
     * @return {object}
     */
    static async update(id, attributes) {
        const response = await axios.patch(`/api/v1/tasks/${id}`, attributes);

        if (response.status !== 200) {
            return {};
        }

        return response.data;
    }

    /**
     * Delete a Task.
     *
     * @param {number} id
     *
     * @return {object}
     */
    static async delete(id) {
        const response = await axios.delete(`/api/v1/tasks/${id}`);

        if (response.status !== 200) {
            return {};
        }

        return response.data;
    }

    /**
     * Restore a Task.
     *
     * @param {number} id
     *
     * @return {object}
     */
    static async restore(id) {
        const response = await axios.delete(
            `/api/v1/tasks/${id}?is_recovery=true`,
        );

        if (response.status !== 200) {
            return {};
        }

        return response.data;
    }
}
