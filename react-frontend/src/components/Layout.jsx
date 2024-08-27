import React from 'react';
import { Outlet } from 'react-router-dom';
import NavBar from './NavBar';
import { Box } from '@mui/material';

const Layout = () => {
    return (
        <div>
            <NavBar />
            <Box p={3}>
                <Outlet />
            </Box>
        </div>
    );
};

export default Layout;
