import React, { useEffect, useState } from 'react';

import { Paper, Typography, withStyles } from '@material-ui/core';
import Task from '../../../models/Task';
import { LinearIndeterminate } from '../../../ui/Loaders';
import { Master as MasterLayout } from '../layouts';

import { Task as TaskForm } from './Forms';

function Edit(props) {
    const [loading, setLoading] = useState(false);
    const [formValues, setFormValues] = useState([]);
    const [task, setTask] = useState({});
    const [message, setMessage] = useState({});

    /**
     * Task verisini API'den getir.
     *
     * @param {number} id
     */
    const fetchTask = async id => {
        setLoading(true);

        try {
            const taskData = await Task.show(id);
            setTask(taskData);
            setLoading(false);
        } catch (error) {
            setLoading(false);
        }
    };

    useEffect(() => {
        const { params } = props.match;
        fetchTask(params.id);
    }, []);

    /**
     * Form gönderildiğinde task güncelle.
     *
     * @param {object} values
     * @param {object} formikHelpers
     */
    const handleSubmit = async (values, { setSubmitting, setErrors }) => {
        setSubmitting(false);
        setLoading(true);

        try {
            const updatedTask = await Task.update(task.id, values);

            setMessage({
                type: 'success',
                body: Lang.get('resources.updated', { name: 'Task' }),
                closed: () => setMessage({}),
            });

            setTask(updatedTask);
            setFormValues([values]);
            setLoading(false);

            // Dilersen başarılı güncellemeden sonra yönlendirme yapılabilir:
            // props.history.push(NavigationUtils.route('backoffice.tasks.index'));
        } catch (error) {
            if (!error.response) {
                throw new Error('Bilinmeyen hata');
            }

            const { errors } = error.response.data;
            setErrors(errors);
            setLoading(false);
        }
    };

    const { classes, ...other } = props;

    const defaultTaskValues = {
        title: '',
        description: '',
        due_date: '',
        status: '',
    };

    return (
        <MasterLayout
            {...other}
            pageTitle="Edit Task"
            tabs={[]}
            message={message}
        >
            <div className={classes.pageContentWrapper}>
                {loading && <LinearIndeterminate />}

                <Paper>
                    <div className={classes.pageContent}>
                        <Typography
                            component="h1"
                            variant="h4"
                            align="center"
                            gutterBottom
                        >
                            Task Düzenleme
                        </Typography>

                        <TaskForm
                            {...other}
                            values={
                                formValues[0]
                                    ? formValues[0]
                                    : { ...defaultTaskValues, ...task }
                            }
                            handleSubmit={handleSubmit}
                            task={task}
                        />
                    </div>
                </Paper>
            </div>
        </MasterLayout>
    );
}

const styles = theme => ({
    pageContentWrapper: {
        width: '100%',
        marginTop: theme.spacing.unit * 3,
        minHeight: '75vh',
        overflowX: 'auto',
    },

    pageContent: {
        padding: theme.spacing.unit * 3,
    },
});

export default withStyles(styles)(Edit);
