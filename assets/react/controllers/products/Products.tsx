import React from "react";
interface Category {
  id: number;
  name: string;
  description: string;
  parent: Category;
  children: Category[];
  products: Product;
}

interface Product {
  id: number;
  name: string;
  description?: string;
  price: number;
  quantity: number;
  category: Category;
  brand: string;
  image: string;
  createdAt: Date;
  updatedAt: Date;
}

export default function ({ products }: { products: string }) {
  const productsParsed = JSON.parse(products) as Product[];

  return (
    <>
      <h1>Products</h1>

      <div className="products-list-wrapper">
        {productsParsed.map((product, idx) => {
          return (
            <div
              key={idx}
              className={`product-wrapper ${
                product.quantity <= 0 ? `sold-out` : null
              }`}
            >
              <div className="product-image">
                <img
                  className="product-image"
                  src={product.image}
                  alt={product.name}
                />
              </div>
              <div className="product-details">
                <div>{product.name}</div>
                <div>{product.brand}</div>
                <div>Price: {product.price}</div>
                <div>
                  <button disabled={product.quantity <= 0 ? true : false}>
                    Add to cart (soon)..
                  </button>
                </div>
              </div>
            </div>
          );
        })}
      </div>
    </>
  );
}
