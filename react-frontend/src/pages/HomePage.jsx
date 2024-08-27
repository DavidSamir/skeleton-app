import React from 'react';
import { Link } from 'react-router-dom';
import { Box, Button, Grid, Typography } from '@mui/material';

const HomePage = () => {
  return (
    <Box p={3}>
      <Grid container spacing={4} justifyContent="center">
        <Grid item xs={12} sm={6} md={4}>
          <Button
            component={Link}
            to="/users"
            variant="contained"
            color="primary"
            fullWidth
            sx={{
              height: '150px',
              display: 'flex',
              justifyContent: 'center',
              alignItems: 'center',
              textAlign: 'center',
              borderRadius: '16px',
            }}
          >
            <Typography variant="h5">Go to Users Page</Typography>
          </Button>
        </Grid>
        <Grid item xs={12} sm={6} md={4}>
          <Button
            component={Link}
            to="/products"
            variant="contained"
            color="secondary"
            fullWidth
            sx={{
              height: '150px',
              display: 'flex',
              justifyContent: 'center',
              alignItems: 'center',
              textAlign: 'center',
              borderRadius: '16px',
            }}
          >
            <Typography variant="h5">Go to Products Page</Typography>
          </Button>
        </Grid>
      </Grid>
    </Box>
  );
};

export default HomePage;
