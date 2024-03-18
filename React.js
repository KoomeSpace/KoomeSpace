import React from "react";
import { useForm } from "react-hook-form";

function Login() {
  const { register, handleSubmit, errors } = useForm();

  // handle form submission
  const onSubmit = (data) => {
    console.log(data);
  };

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <input {...register("email", { required: true })} />
      {errors.email && <p>Email is required</p>}

      <input {...register("password", { required: true })} />
      {errors.password && <p>Password is required</p>}

      <button type="submit">Log in</button>
    </form>
  );
}

export default Login;