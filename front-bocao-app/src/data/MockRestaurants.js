const mockRestaurants = [
  {
    id: 1,
    name: 'Pasta Paradise',
    cuisine: 'Italian',
    rating: 4.5,
    priceRange: '$$',
    image: 'https://images.unsplash.com/photo-1555949258-eb67b1ef0ceb',
    comments: [
      { id: 1, author: 'Maria', text: 'The carbonara is to die for! Authentic Italian flavors.', rating: 5 },
      { id: 2, author: 'John', text: 'Great tiramisu but the pasta was slightly overcooked', rating: 4 }
    ]
  },
  {
    id: 2,
    name: 'Burger Barn',
    cuisine: 'American',
    rating: 4.2,
    priceRange: '$',
    image: 'https://images.unsplash.com/photo-1571091718767-18b5b1457add',
    comments: [
      { id: 1, author: 'Alex', text: 'Best burgers in town! The bacon double cheeseburger is amazing.', rating: 5 },
      { id: 2, author: 'Sarah', text: 'Good milkshakes but fries were too salty', rating: 3 }
    ]
  },
  {
    id: 3,
    name: 'Sushi World',
    cuisine: 'Japanese',
    rating: 4.7,
    priceRange: '$$$',
    image: 'https://images.unsplash.com/photo-1583623025817-d180a2221d0a',
    comments: [
      { id: 1, author: 'Kenji', text: 'Fresh fish and perfect rice. Omakase experience was worth every penny.', rating: 5 },
      { id: 2, author: 'Lisa', text: 'Beautiful presentation but some rolls were too small for the price', rating: 4 }
    ]
  },
  {
    id: 4,
    name: 'Taco Fiesta',
    cuisine: 'Mexican',
    rating: 4.0,
    priceRange: '$',
    image: 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47',
    comments: [
      { id: 1, author: 'Carlos', text: 'Authentic street tacos with amazing homemade salsas', rating: 5 },
      { id: 2, author: 'Emma', text: 'Good flavors but service was slow during lunch rush', rating: 3 }
    ]
  },
  {
    id: 5,
    name: 'Curry House',
    cuisine: 'Indian',
    rating: 4.4,
    priceRange: '$$',
    image: 'https://images.unsplash.com/photo-1601050690597-df0568f70950',
    comments: [
      { id: 1, author: 'Raj', text: 'Butter chicken is the best Ive had outside of Delhi!', rating: 5 },
      { id: 2, author: 'Olivia', text: 'Naan bread was perfect but lamb curry was too spicy', rating: 4 }
    ]
  },
  {
    id: 6,
    name: 'Le Petit Bistro',
    cuisine: 'French',
    rating: 4.6,
    priceRange: '$$$',
    image: 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0',
    comments: [
      { id: 1, author: 'Sophie', text: 'Perfect coq au vin and the wine pairing was excellent', rating: 5 },
      { id: 2, author: 'Thomas', text: 'Elegant atmosphere but portions were quite small', rating: 4 }
    ]
  },
  {
    id: 7,
    name: 'Dragon Palace',
    cuisine: 'Chinese',
    rating: 4.1,
    priceRange: '$$',
    image: 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c',
    comments: [
      { id: 1, author: 'Wei', text: 'Authentic Sichuan dishes with just the right amount of heat', rating: 5 },
      { id: 2, author: 'Michelle', text: 'Good dim sum but the fried rice was bland', rating: 3 }
    ]
  },
  {
    id: 8,
    name: 'The Steakhouse',
    cuisine: 'Steakhouse',
    rating: 4.8,
    priceRange: '$$$',
    image: 'https://images.unsplash.com/photo-1600891964599-f61ba0e24092',
    comments: [
      { id: 1, author: 'Michael', text: 'Perfectly cooked ribeye with amazing truffle mashed potatoes', rating: 5 },
      { id: 2, author: 'Jessica', text: 'Expensive but worth it for special occasions', rating: 5 }
    ]
  },
  {
    id: 9,
    name: 'Mediterranean Grill',
    cuisine: 'Mediterranean',
    rating: 4.3,
    priceRange: '$$',
    image: 'https://images.unsplash.com/photo-1559847844-5315695dadae',
    comments: [
      { id: 1, author: 'Nadia', text: 'Best hummus and falafel in the city!', rating: 5 },
      { id: 2, author: 'David', text: 'Great vegetarian options but meat skewers were dry', rating: 3 }
    ]
  },
  {
    id: 10,
    name: 'Pizza Napoli',
    cuisine: 'Pizza',
    rating: 4.0,
    priceRange: '$$',
    image: 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38',
    comments: [
      { id: 1, author: 'Luca', text: 'Wood-fired oven gives the perfect crust - just like in Naples!', rating: 5 },
      { id: 2, author: 'Grace', text: 'Good margherita pizza but delivery took too long', rating: 3 }
    ]
  }
];

export default mockRestaurants;
