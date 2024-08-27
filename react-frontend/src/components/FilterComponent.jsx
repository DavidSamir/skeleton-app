import React, { useState, useContext } from 'react';
import { DataContext } from '../context/DataContext';
import { TextField, MenuItem, FormControl, InputLabel, Select, Box } from '@mui/material';

const FilterComponent = () => {
  const { pageSize, setPageSize, filters, setFilters } = useContext(DataContext);
  const [searchTerm, setSearchTerm] = useState('');

  const handlePageSizeChange = (e) => {
    setPageSize(Number(e.target.value));
  };

  const handleSearchChange = (e) => {
    setSearchTerm(e.target.value);
    setFilters({ ...filters, search: e.target.value });
  };

  return (
    <Box display="flex" justifyContent="space-between" alignItems="center" mb={2}>
      <FormControl variant="outlined" size="small" sx={{ minWidth: 120 }}>
        <InputLabel>Page Size</InputLabel>
        <Select
          value={pageSize}
          onChange={handlePageSizeChange}
          label="Page Size"
        >
          <MenuItem value={5}>5</MenuItem>
          <MenuItem value={10}>10</MenuItem>
          <MenuItem value={20}>20</MenuItem>
          <MenuItem value={50}>50</MenuItem>
        </Select>
      </FormControl>

      <TextField
        variant="outlined"
        size="small"
        label="Search"
        value={searchTerm}
        onChange={handleSearchChange}
        sx={{ ml: 2 }}
      />
    </Box>
  );
};

export default FilterComponent;
