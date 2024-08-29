import React, { useContext, useEffect, useState } from 'react';
import DataTable from '../components/DataTable';
import FilterComponent from '../components/FilterComponent';
import PaginationComponent from '../components/PaginationComponent';
import { DataContext } from '../context/DataContext';
import axios from 'axios';
import { CircularProgress, Typography, Box, Container } from '@mui/material';

const UsersPage = () => {
  const { users, setUsers, pageSize, currentPage } = useContext(DataContext);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchUsers = async () => {
      setLoading(true);
      setError(null);
      try {
        const response = await axios.get(
          `https://dummyjson.com/users?limit=${pageSize}&skip=${(currentPage - 1) * pageSize}`
        );
        
        const filteredUsers = response.data.users.map(user => ({
          image: user.image,
          "First Name": user.firstName,
          "Last Name": user.lastName,
          age: user.age,
          gender: user.gender,
          phone: user.phone,
          "Birth Date": user.birthDate,
          role: user.role,
        }));

        setUsers(filteredUsers);
      } catch (error) {
        setError('Failed to fetch users.');
      } finally {
        setLoading(false);
      }
    };

    fetchUsers();
  }, [pageSize, currentPage, setUsers]);

  return (
    <Container>
      <Typography variant="h4" gutterBottom>
        Users Page
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
        <DataTable data={users} />
      )}
      <Box mt={4}>
        <PaginationComponent />
      </Box>
    </Container>
  );
};

export default UsersPage;
