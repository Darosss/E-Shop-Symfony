import React, { useState } from "react";
import CreateProduct from "./CreateProduct";
import { Category, Product } from "../types";

export default function ({
  products,
  admin,
  categories,
}: {
  products: string;
  admin: boolean;
  categories: string;
}) {
  const productsParsed = JSON.parse(products) as Product[];
  const categoriesParsed = JSON.parse(categories) as Category[];
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
      {showAdminOptions ? (
        <CreateProduct categories={categoriesParsed} />
      ) : null}

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
                    <button>Edit</button> {/*TODO:Add later edit on click */}
                    <button>Remove</button>
                    {/*TODO:Add later remove on click */}
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
