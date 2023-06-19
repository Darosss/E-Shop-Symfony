export interface Category {
  id: number;
  name: string;
  description: string;
  parent: Category;
  children: Category[];
  products: Product;
}

export interface Product {
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
