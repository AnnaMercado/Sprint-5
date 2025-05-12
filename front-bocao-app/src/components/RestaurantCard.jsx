import { useState } from 'react';

function RestaurantCard({ restaurant, onAddComment }) {
  const [showComments, setShowComments] = useState(false);
  const [showModal, setShowModal] = useState(false);
  const [newComment, setNewComment] = useState({ author: '', text: '', rating: 5 });

  const handleSubmit = (e) => {
    e.preventDefault();
    if (!newComment.author || !newComment.text) return;

    const commentToAdd = { id: Date.now(), ...newComment };
    onAddComment(restaurant.id, commentToAdd);
    setNewComment({ author: '', text: '', rating: 5 });
    setShowModal(false);
  };

  return (
    <div className="restaurant-card compact">
      <img src={restaurant.image} alt={restaurant.name} className="card-image" />
      <div className="card-content">
        <div className="card-header">
          <h3>{restaurant.name}</h3>
          <span className="cuisine-badge">{restaurant.cuisine}</span>
        </div>
        <div className="card-details">
          <div className="rating">★ {restaurant.rating}</div>
          <div className="price">{restaurant.priceRange}</div>
        </div>
        <button className="comments-toggle" onClick={() => setShowComments(!showComments)}>
          {showComments ? 'Hide Reviews' : 'Show Reviews'}
        </button>

        {showComments && (
          <div className="comments-section">
            <div className="comments-header">
              <h4>Customer Reviews</h4>
              <button className="add-review-btn" onClick={() => setShowModal(true)}>
                + Add Review
              </button>
            </div>
            {restaurant.comments.map(comment => (
              <div key={comment.id} className="comment">
                <div className="comment-header">
                  <span className="comment-author">{comment.author}</span>
                  <span className="comment-rating">★ {comment.rating}</span>
                </div>
                <div className="comment-text">{comment.text}</div>
              </div>
            ))}
          </div>
        )}
      </div>

      {showModal && (
        <div className="modal-overlay">
          <div className="comment-modal">
            <div className="modal-header">
              <h3>Add Your Review for {restaurant.name}</h3>
              <button className="close-modal" onClick={() => setShowModal(false)}>&times;</button>
            </div>
            <form onSubmit={handleSubmit} className="comment-form">
              <div className="form-group">
                <label>Your Name:</label>
                <input
                  type="text"
                  value={newComment.author}
                  onChange={(e) => setNewComment({ ...newComment, author: e.target.value })}
                  required
                />
              </div>
              <div className="form-group">
                <label>Your Review:</label>
                <textarea
                  value={newComment.text}
                  onChange={(e) => setNewComment({ ...newComment, text: e.target.value })}
                  required
                />
              </div>
              <div className="form-group">
                <label>Rating:</label>
                <div className="rating-selector">
                  {[1, 2, 3, 4, 5].map(star => (
                    <span
                      key={star}
                      className={`star ${star <= newComment.rating ? 'selected' : ''}`}
                      onClick={() => setNewComment({ ...newComment, rating: star })}
                    >
                      ★
                    </span>
                  ))}
                </div>
              </div>
              <div className="form-actions">
                <button type="button" className="cancel-btn" onClick={() => setShowModal(false)}>
                  Cancel
                </button>
                <button type="submit" className="submit-btn">Submit Review</button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
}

export default RestaurantCard;
