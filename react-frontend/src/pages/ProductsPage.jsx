import React, { useEffect, useContext, useState } from 'react';
import axios from 'axios';
import { DataContext } from '../context/DataContext';
import FilterComponent from '../components/FilterComponent';
import PaginationComponent from '../components/PaginationComponent';
import { CircularProgress, Typography, Box, Container, Grid, Card, CardContent, CardMedia, Button } from '@mui/material';
import { Link } from 'react-router-dom';

const ProductsPage = () => {
  const { products, setProducts, pageSize, currentPage } = useContext(DataContext);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchProducts = async () => {
      setLoading(true);
      setError(null);
      try {
        const response = await axios.get(
          `https://dummyjson.com/products?limit=${pageSize}&skip=${(currentPage - 1) * pageSize}`
        );
        setProducts(response.data.products);
      } catch (error) {
        setError('Failed to fetch products.');
      } finally {
        setLoading(false);
      }
    };

    fetchProducts();
  }, [pageSize, currentPage, setProducts]);

  return (
    <Container>
      <Typography variant="h4" gutterBottom>
        Products Page
      </Typography>
      <Box mb={2}>
        <FilterComponent />
      </Box>
      {loading ? (
        <Box display="flex" justifyContent="center" mt={4}>
          <CircularProgress />
        </Box>
      ) : error ? (
        <Typography color="error" align="center" mt={4}>
          {error}
        </Typography>
      ) : (
        <Grid container spacing={4}>
          {products.map((product) => (
            <Grid item key={product.id} xs={12} sm={6} md={4}>
              <Card>
                <CardMedia
                  component="img"
                  height="140"
                  image={product.thumbnail}
                  alt={product.title}
                />
                <CardContent>
                  <Typography variant="h6" gutterBottom>
                    {product.title}
                  </Typography>
                  <Typography variant="body2" color="text.secondary">
                    {product.description}
                  </Typography>
                  <Typography variant="subtitle1" color="primary" mt={1}>
                    ${product.price}
                  </Typography>
                  <Button 
                    component={Link} 
                    to={`/products/${product.id}`} 
                    variant="contained" 
                    color="primary" 
                    fullWidth 
                    mt={2}
                  >
                    View Details
                  </Button>
                </CardContent>
              </Card>
            </Grid>
          ))}
        </Grid>
      )}
      <Box mt={4}>
        <PaginationComponent />
      </Box>
    </Container>
  );
};

export default ProductsPage;
