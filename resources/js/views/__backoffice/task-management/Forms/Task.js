import React from 'react';
import PropTypes from 'prop-types';
import { Form, Formik } from 'formik';
import * as Yup from 'yup';

import {
    Button,
    FormControl,
    FormHelperText,
    Grid,
    Input,
    InputLabel,
    MenuItem,
    Select,
    withStyles,
} from '@material-ui/core';

import { DatePicker, MuiPickersUtilsProvider } from 'material-ui-pickers';
import MomentUtils from '@date-io/moment';
import moment from 'moment';

const Task = props => {
    const { classes, values, handleSubmit } = props;

    return (
        <Formik
            initialValues={values}
            validationSchema={Yup.object().shape({
                title: Yup.string().required(
                    Lang.get('validation.required', {
                        attribute: 'title',
                    }),
                ),

                lastname: Yup.string().required(
                    Lang.get('validation.required', {
                        attribute: 'lastname',
                    }),
                ),
            })}
            onSubmit={async (values, form) => {
                let mappedValues = {};
                let valuesArray = Object.values(values);

                // Format values specially the object ones (i.e Moment)
                Object.keys(values).forEach((filter, key) => {
                    if (
                        valuesArray[key] !== null &&
                        typeof valuesArray[key] === 'object' &&
                        valuesArray[key].hasOwnProperty('_isAMomentObject')
                    ) {
                        mappedValues[filter] = moment(valuesArray[key]).format(
                            'YYYY-MM-DD HH:mm',
                        );

                        return;
                    }

                    mappedValues[filter] = valuesArray[key];
                });

                await handleSubmit(mappedValues, form);
            }}
            validateOnBlur={false}
        >
            {({
                values,
                errors,
                submitCount,
                isSubmitting,
                handleChange,
                setFieldValue,
            }) => (
                <Form>
                    <Grid container spacing={24}>
                        <Grid item xs={12} sm={6}>
                            <FormControl
                                className={classes.formControl}
                                error={
                                    submitCount > 0 &&
                                    errors.hasOwnProperty('title')
                                }
                            >
                                <InputLabel htmlFor="title">
                                    Title{' '}
                                    <span className={classes.required}>*</span>
                                </InputLabel>

                                <Input
                                    id="title"
                                    name="title"
                                    value={values.title}
                                    onChange={handleChange}
                                    fullWidth
                                />

                                {submitCount > 0 &&
                                    errors.hasOwnProperty('title') && (
                                        <FormHelperText>
                                            {errors.title}
                                        </FormHelperText>
                                    )}
                            </FormControl>
                        </Grid>

                        <Grid item xs={12} sm={6}>
                            <FormControl
                                className={classes.formControl}
                                error={
                                    submitCount > 0 &&
                                    errors.hasOwnProperty('user_id')
                                }
                            >
                                <InputLabel htmlFor="user_id">
                                    Assigned User{' '}
                                </InputLabel>

                                <Select
                                    id="user_id"
                                    name="user_id"
                                    value={values.user_id}
                                    onChange={handleChange}
                                    input={<Input fullWidth />}
                                    autoWidth
                                >
                                    <MenuItem value="">
                                        Please select the user
                                    </MenuItem>

                                    <MenuItem value="1">
                                        Jovert Palonpon
                                    </MenuItem>

                                    <MenuItem value="2">Ian Lumbao</MenuItem>
                                </Select>

                                {submitCount > 0 &&
                                    errors.hasOwnProperty('user_id') && (
                                        <FormHelperText>
                                            {errors.user_id}
                                        </FormHelperText>
                                    )}
                            </FormControl>
                        </Grid>
                    </Grid>

                    <Grid container spacing={24}>
                        <Grid item xs={12} sm={4}>
                            <FormControl
                                className={classes.formControl}
                                error={
                                    submitCount > 0 &&
                                    errors.hasOwnProperty('task_status_id')
                                }
                            >
                                <InputLabel htmlFor="task_status_id">
                                    Status{' '}
                                </InputLabel>

                                <Select
                                    id="task_status_id"
                                    name="task_status_id"
                                    value={values.task_status_id}
                                    onChange={handleChange}
                                    input={<Input fullWidth />}
                                    autoWidth
                                >
                                    <MenuItem value="">
                                        Please select the task status
                                    </MenuItem>

                                    <MenuItem value="1">Pending</MenuItem>

                                    <MenuItem value="2">In Progress</MenuItem>

                                    <MenuItem value="3">Completed</MenuItem>
                                </Select>

                                {submitCount > 0 &&
                                    errors.hasOwnProperty('task_status_id') && (
                                        <FormHelperText>
                                            {errors.task_status_id}
                                        </FormHelperText>
                                    )}
                            </FormControl>
                        </Grid>

                        <Grid item xs={12} sm={4}>
                            <FormControl
                                className={classes.formControl}
                                error={
                                    submitCount > 0 &&
                                    errors.hasOwnProperty('start_date')
                                }
                            >
                                <MuiPickersUtilsProvider utils={MomentUtils}>
                                    <DatePicker
                                        id="start_date"
                                        name="start_date"
                                        label="Start Date"
                                        placeholder="Please pick the start_date"
                                        value={values.start_date}
                                        onChange={date =>
                                            setFieldValue('start_date', date)
                                        }
                                        format="YYYY-MM-DD HH:mm"
                                        keyboard
                                        clearable
                                        disableFuture
                                    />
                                </MuiPickersUtilsProvider>

                                {submitCount > 0 &&
                                    errors.hasOwnProperty('start_date') && (
                                        <FormHelperText>
                                            {errors.start_date}
                                        </FormHelperText>
                                    )}
                            </FormControl>
                        </Grid>

                        <Grid item xs={12} sm={4}>
                            <FormControl
                                className={classes.formControl}
                                error={
                                    submitCount > 0 &&
                                    errors.hasOwnProperty('due_date')
                                }
                            >
                                <MuiPickersUtilsProvider utils={MomentUtils}>
                                    <DatePicker
                                        id="due_date"
                                        name="due_date"
                                        label="End Date"
                                        placeholder="Please pick the due_date"
                                        value={values.due_date}
                                        onChange={date =>
                                            setFieldValue('due_date', date)
                                        }
                                        format="YYYY-MM-DD HH:mm"
                                        maxDate={moment()
                                            .subtract(10, 'y')
                                            .subtract(10, 'd')
                                            .format('YYYY-MM-DD HH:mm')}
                                        keyboard
                                        clearable
                                        disableFuture
                                    />
                                </MuiPickersUtilsProvider>

                                {submitCount > 0 &&
                                    errors.hasOwnProperty('due_date') && (
                                        <FormHelperText>
                                            {errors.due_date}
                                        </FormHelperText>
                                    )}
                            </FormControl>
                        </Grid>
                    </Grid>

                    <Grid container spacing={24}>
                        <Grid item xs={12} sm={12}>
                            <FormControl
                                className={classes.formControl}
                                error={
                                    submitCount > 0 &&
                                    errors.hasOwnProperty('description')
                                }
                            >
                                <InputLabel htmlFor="description">
                                    Description{' '}
                                </InputLabel>

                                <Input
                                    id="description"
                                    name="description"
                                    value={values.description}
                                    onChange={handleChange}
                                    fullWidth
                                    multiline
                                    rows={3}
                                />

                                {submitCount > 0 &&
                                    errors.hasOwnProperty('description') && (
                                        <FormHelperText>
                                            {errors.description}
                                        </FormHelperText>
                                    )}
                            </FormControl>
                        </Grid>
                    </Grid>

                    <div className={classes.sectionSpacer} />

                    <Grid container spacing={24} justify="flex-end">
                        <Grid item>
                            <Button
                                type="submit"
                                variant="contained"
                                color="primary"
                                disabled={
                                    (errors &&
                                        Object.keys(errors).length > 0 &&
                                        submitCount > 0) ||
                                    isSubmitting
                                }
                                onClick={handleSubmit}
                            >
                                Submit
                            </Button>
                        </Grid>
                    </Grid>
                </Form>
            )}
        </Formik>
    );
};

Task.propTypes = {
    values: PropTypes.object.isRequired,
    handleSubmit: PropTypes.func.isRequired,
};

const styles = theme => ({
    formControl: {
        minWidth: '100%',
    },

    required: {
        color: theme.palette.error.main,
    },
});

export default withStyles(styles)(Task);
