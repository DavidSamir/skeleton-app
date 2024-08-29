import React from 'react';
import { Link } from 'react-router-dom';
import { Box, Button, Typography } from '@mui/material';

const HomePage = () => {
  return (
    <Box p={3}>
      <Box
        className="home"
      >
        <Box>
          <Button component={Link} to="/users" variant="contained" >
            <Typography variant="h5">Go to Users Page</Typography>
          </Button>
        </Box>
        <Box>
          <Button component={Link} to="/products" variant="contained" >
            <Typography variant="h5">Go to Products Page</Typography>
          </Button>
        </Box>
      </Box>
    </Box>
  );
};

export default HomePage;
