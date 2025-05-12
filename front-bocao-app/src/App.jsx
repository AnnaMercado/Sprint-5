import { useState } from 'react';
import './App.css';

import NavBar from './components/NavBar';
import Footer from './components/Footer';
import RestaurantCard from './components/RestaurantCard';

import mockRestaurants from './data/mockRestaurants';

function App() {
  const [restaurants, setRestaurants] = useState(mockRestaurants);

  const addComment = (restaurantId, newComment) => {
    setRestaurants(prev =>
      prev.map(r =>
        r.id === restaurantId ? { ...r, comments: [...r.comments, newComment] } : r
      )
    );
  };

  return (
    <div className="app-container">
      <NavBar />
      <div className="main-content">
        <div className="restaurant-grid">
          {restaurants.map(r => (
            <RestaurantCard key={r.id} restaurant={r} onAddComment={addComment} />
          ))}
        </div>
      </div>
      <Footer />
    </div>
  );
}

export default App;
