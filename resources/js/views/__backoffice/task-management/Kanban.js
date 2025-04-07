import React, { useEffect, useMemo, useState } from 'react';
import Task from '../../../models/Task';
import { Master as MasterLayout } from '../layouts';
import * as NavigationUtils from '../../../helpers/Navigation';
import { Label, Value, Wrapper } from 'react-kanban-dnd/docs/components';
import ReactKanban from 'react-kanban-dnd/src';

function Kanban(props) {
    const statusLabels = {
        todo: 'Pending',
        in_progress: 'In Progress',
        done: 'Completed',
    };

    const statusList = ['todo', 'in_progress', 'done'];

    const [tasks, setTasks] = useState([]);
    const { ...childProps } = props;
    const { history } = props;

    const fetchTasks = async () => {
        const res = await Task.getAll();
        setTasks(res.data.data);
    };

    useEffect(() => {
        fetchTasks();
    }, []);

    const handleDrop = async (task, newStatus) => {
        if (task.status !== newStatus) {
            await Task.update(task.id, { ...task, status: newStatus });

            // 5 saniye sonra verileri güncelle
            setTimeout(() => {
                fetchTasks();
            }, 5000);
        }
    };

    const groupTasksByStatus = () => {
        return statusList.map((status, statusKey) => ({
            id: status,
            title: statusLabels[status],
            rows: tasks.filter(task => task.task_status_id === statusKey + 1),
        }));
    };

    const tabs = useMemo(
        () => [
            {
                name: 'Kanban',
                active: true,
            },
        ],
        [],
    );

    const primaryAction = useMemo(
        () => ({
            text: Lang.get('resources.create', { name: 'Task' }),
            clicked: () =>
                history.push(
                    NavigationUtils.route(
                        'backoffice.task-management.tasks.create',
                    ),
                ),
        }),
        [history],
    );

    const handleKanbanDrop = ({ source, destination }) => {
        const movedTask = tasks.find(task => task.id === source.id);
        if (!movedTask || !destination) return;

        const newStatus = destination.droppableId;

        handleDrop(movedTask, newStatus);
    };

    const renderCard = row => (
        <Wrapper>
            <Text>
                <Label>Title:</Label>
                <Value>{row.title}</Value>
            </Text>
            <Text>
                <Value>{row.description}</Value>
            </Text>
        </Wrapper>
    );

    return (
        <MasterLayout
            {...childProps}
            pageTitle={Lang.get('navigation.kanban')}
            primaryAction={primaryAction}
            tabs={tabs}
            alert={alert}
        >
            <ReactKanban
                columns={groupTasksByStatus()}
                renderCard={renderCard}
                columnWrapperStyle={}
                columnHeaderStyle={}
                columnStyle={}
                columnTitleStyle={}
                cardWrapperStyle={}
                onDragEnd={handlekanbanDrop}
            />
        </MasterLayout>
    );
}

export default Kanban;
