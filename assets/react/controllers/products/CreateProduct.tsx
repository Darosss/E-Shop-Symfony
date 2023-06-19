import React, { useState } from "react";
import Modal from "../helpers/Modal";
import { SubmitHandler, useForm, Controller } from "react-hook-form";
import { Category, Product } from "../types";
import axios from "axios";
import Select from "react-select";
import { productsURL } from "../helpers/axiosConfig";

interface SelectOption {
  value: string;
  label: string;
}

interface CreateProductInput
  extends Omit<Product, "id" | "createdAt" | "updatedAt" | "category"> {
  category_id: SelectOption;
}

export default function ({ categories }: { categories: Category[] }) {
  const [isOpen, setIsOpen] = useState<boolean>(false);
  const [postInfo, setPostInfo] = useState<string>("");

  const {
    register,
    handleSubmit,
    control,
    formState: { errors },
  } = useForm<CreateProductInput>();

  function openModal() {
    setIsOpen(true);
  }

  function closeModal() {
    setIsOpen(false);
  }

  function createPost(data: CreateProductInput) {
    console.log(data, "x");
    axios
      .post(productsURL, { ...data, category_id: data.category_id.value })
      .then((response) => {
        setPostInfo(response.data);
      })
      .catch((err) => console.log(err));
  }

  const onSubmit: SubmitHandler<CreateProductInput> = (data) =>
    createPost(data);

  return (
    <>
      <div>
        <button onClick={openModal}>Add new product</button>
        <Modal
          isOpen={isOpen}
          setIsOpen={setIsOpen}
          onClose={closeModal}
          title="Create product"
        >
          <form
            onSubmit={handleSubmit(onSubmit)}
            className="create-product-modal"
          >
            <input
              placeholder="name"
              {...register("name", { required: true })}
            />
            {errors.name && <span>Name is required</span>}

            <input
              placeholder="price"
              type="number"
              {...register("price", { required: true })}
            />
            {errors.price && <span>Price is required</span>}

            <input
              defaultValue=""
              placeholder="description"
              {...register("description")}
            />
            <input
              placeholder="quantity"
              type="number"
              {...register("quantity", { required: true })}
            />
            {errors.quantity && <span>Quantity is required</span>}

            <input
              placeholder="brand"
              {...register("brand", { required: true })}
            />
            {errors.brand && <span>Brand is required</span>}

            {/* //TODO: this will be upload file + path in server */}
            <input
              placeholder="image"
              {...register("image", { required: true })}
            />
            {errors.image && <span>Image is required</span>}

            <Controller
              name="category_id"
              control={control}
              rules={{ required: true }}
              render={({ field }) => (
                <Select
                  {...field}
                  options={categories?.map((category) => {
                    return {
                      label: category.name,
                      value: category.id.toString(),
                    };
                  })}
                />
              )}
            />
            {errors.category_id && <span>Category is required</span>}
            <input type="submit" value="Create" />
            <span> {postInfo}</span>
          </form>
        </Modal>
      </div>
    </>
  );
}
