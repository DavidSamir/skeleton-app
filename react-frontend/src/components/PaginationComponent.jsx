import React, { useContext } from 'react';
import { DataContext } from '../context/DataContext';
import { Button, Box, Typography } from '@mui/material';

const PaginationComponent = () => {
    const { currentPage, setCurrentPage } = useContext(DataContext);

    const handlePageChange = (page) => {
        setCurrentPage(page);
    };

    return (
        <Box display="flex" alignItems="center" justifyContent="center" mt={2}>
            <Button
                variant="contained"
                color="primary"
                onClick={() => handlePageChange(currentPage - 1)}
                disabled={currentPage === 1}
                sx={{ mr: 2 }}
            >
                Previous
            </Button>
            <Typography variant="body1" component="span">
                Page {currentPage}
            </Typography>
            <Button
                variant="contained"
                color="primary"
                onClick={() => handlePageChange(currentPage + 1)}
                sx={{ ml: 2 }}
            >
                Next
            </Button>
        </Box>
    );
};

export default PaginationComponent;
