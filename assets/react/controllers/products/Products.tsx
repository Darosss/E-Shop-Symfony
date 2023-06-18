import React, { useState } from "react";
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

export default function ({
  products,
  admin,
}: {
  products: string;
  admin: boolean;
}) {
  const productsParsed = JSON.parse(products) as Product[];

  const [showAdminOptions, setShowAdminOptions] = useState<boolean>(false);
  //TODO: add later to local storage

  return (
    <>
      <h1>Products</h1>
      {admin ? (
        <button onClick={() => setShowAdminOptions(!showAdminOptions)}>
          Toggle admin options
        </button>
      ) : null}
      {showAdminOptions ? <button>Add new </button> : null}
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
                {showAdminOptions ? (
                  <div>
                    <button>Edit</button> {/*Add later edit on click */}
                    <button>Remove</button>
                    {/*Add later remove on click */}
                  </div>
                ) : null}
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
