import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { useParams } from 'react-router-dom';
import { CircularProgress, Typography, Box, Container, Card, CardContent, CardMedia, Grid, Paper } from '@mui/material';

const ProductDetails = () => {
  const { id } = useParams();
  const [product, setProduct] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchProduct = async () => {
      setLoading(true);
      setError(null);
      try {
        const response = await axios.get(`https://dummyjson.com/products/${id}`);
        setProduct(response.data);
      } catch (error) {
        setError('Failed to fetch product details.');
      } finally {
        setLoading(false);
      }
    };

    fetchProduct();
  }, [id]);

  return (
    <Container maxWidth="md">
      {loading ? (
        <Box display="flex" justifyContent="center" mt={4}>
          <CircularProgress />
        </Box>
      ) : error ? (
        <Typography color="error" align="center" mt={4}>
          {error}
        </Typography>
      ) : (
        product && (
          <Paper elevation={3} sx={{ p: 4, mt: 4 }}>
            <Grid container spacing={4}>
              <Grid item xs={12} sm={6}>
                <CardMedia
                  component="img"
                  height="400"
                  image={product.thumbnail}
                  alt={product.title}
                  sx={{ borderRadius: 2 }}
                />
              </Grid>
              <Grid item xs={12} sm={6}>
                <CardContent>
                  <Typography variant="h4" gutterBottom>
                    {product.title}
                  </Typography>
                  <Typography variant="body1" paragraph>
                    {product.description}
                  </Typography>
                  <Typography variant="h6" color="primary" gutterBottom>
                    ${product.price}
                  </Typography>
                  <Typography variant="body2" color="text.secondary" gutterBottom>
                    Brand: {product.brand}
                  </Typography>
                  <Typography variant="body2" color="text.secondary">
                    Category: {product.category}
                  </Typography>
                </CardContent>
              </Grid>
            </Grid>
          </Paper>
        )
      )}
    </Container>
  );
};

export default ProductDetails;
